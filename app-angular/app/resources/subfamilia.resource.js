// app/resources/subfamilia.resource.js
(function() {
  'use strict';

  angular
    .module('sagdApp.resources')
    .factory('Subfamilia', Subfamilia);

  Subfamilia.$inject = ['api'];

  /* @ngInject */
  function Subfamilia(api, pnotify) {
    var endpoint = '/subfamilia';
    var modelName = 'Subfamilia';

    var resource = {
      all: obtenerSubfamilias,
      create: crearSubfamilia,
      show: mostrarSubfamilia,
      update: actualizarSubfamilia,
      delete: eliminarSubfamilia
    };
    return resource;

    //////////////////////////////////////////////////

    function obtenerSubfamilias(field, value) {
      var endpointWithParams = endpoint + (field && value ? '/' + field + '/' + value : '');
      return api.get(endpointWithParams)
        .then(obtenerComplete)
        .catch(obtenerFailed);

      function obtenerComplete(response) {
        return response.data;
      }

      function obtenerFailed(error) {
        console.error('No se pudo obtener el recurso ' + modelName + ' ' + error.data);
      }
    }

    function crearSubfamilia(data) {
      return api.post(endpoint, data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.subfamilia;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarSubfamilia(id) {
      return api.get(endpoint + '/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return response.data.subfamilia;
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarSubfamilia(id, data) {
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

    function eliminarSubfamilia(id) {
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

