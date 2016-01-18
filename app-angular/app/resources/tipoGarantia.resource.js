// app/resources/tipoGarantia.resource.js
(function() {
  'use strict';

  angular
    .module('sagdApp.resources')
    .factory('TipoGarantia', TipoGarantia);

  TipoGarantia.$inject = ['api'];

  /* @ngInject */
  function TipoGarantia(api, pnotify) {
    var endpoint = '/tipo-garantia';
    var modelName = 'TipoGarantia';

    var resource = {
      all: obtenerTipoGarantias,
      create: crearTipoGarantia,
      show: mostrarTipoGarantia,
      update: actualizarTipoGarantia,
      delete: eliminarTipoGarantia
    };
    return resource;

    //////////////////////////////////////////////////

    function obtenerTipoGarantias() {
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

    function crearTipoGarantia(data) {
      return api.post(endpoint, data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.tipoGarantia;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarTipoGarantia(id) {
      return api.get(endpoint + '/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return response.data.tipoGarantia;
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarTipoGarantia(id, data) {
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

    function eliminarTipoGarantia(id) {
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

