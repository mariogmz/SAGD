// app/resources/margen.resource.js
(function() {
  'use strict';

  angular
    .module('sagdApp.resources')
    .factory('Margen', Margen);

  Margen.$inject = ['api'];

  /* @ngInject */
  function Margen(api, pnotify) {
    var endpoint = '/margen';
    var modelName = 'Margen';

    var resource = {
      all: obtenerMargenes,
      create: crearMargen,
      show: mostrarMargen,
      update: actualizarMargen,
      delete: eliminarMargen
    };
    return resource;

    //////////////////////////////////////////////////

    function obtenerMargenes() {
      return api.get(endpoint)
        .then(obtenerComplete)
        .catch(obtenerFailed);

      function obtenerComplete(response) {
        return response.data;
      }

      function obtenerFailed(error) {
        console.error('No se pudo obtener el recurso ' + modelName + ' ' + error.data);
      }
    }

    function crearMargen(data) {
      return api.post(endpoint, data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.margen;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarMargen(id) {
      return api.get(endpoint + '/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return response.data.margen;
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarMargen(id, data) {
      return api.put(endpoint + '/', id, data)
        .then(actualizarComplete)
        .catch(actualizarFailed);

      function actualizarComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data;
      }

      function actualizarFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function eliminarMargen(id) {
      return api.delete(endpoint + '/', id)
        .then(eliminarComplete)
        .catch(eliminarFailed);

      function eliminarComplete(response) {
        console.log(response.data.message);
        return response.data;
      }

      function eliminarFailed(error) {
        console.error(error.data.error);
      }
    }

  }

})();

