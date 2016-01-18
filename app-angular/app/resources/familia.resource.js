// app/resources/familia.resource.js
(function() {
  'use strict';

  angular
    .module('sagdApp.resources')
    .factory('Familia', Familia);

  Familia.$inject = ['api'];

  /* @ngInject */
  function Familia(api, pnotify) {
    var endpoint = '/familia';
    var modelName = 'Familia';

    var resource = {
      all: obtenerFamilias,
      create: crearFamilia,
      show: mostrarFamilia,
      update: actualizarFamilia,
      delete: eliminarFamilia
    };
    return resource;

    //////////////////////////////////////////////////

    function obtenerFamilias() {
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

    function crearFamilia(data) {
      return api.post(endpoint, data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.familia;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarFamilia(id) {
      return api.get(endpoint + '/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return response.data.familia;
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarFamilia(id, data) {
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

    function eliminarFamilia(id) {
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

