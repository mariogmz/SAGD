// app/blocks/codigoPostal/codigoPostal.resource.js

(function() {
  'use strict';

  angular
    .module('blocks.domicilio')
    .factory('CodigoPostal', CodigoPostal);

  CodigoPostal.$inject = ['api', 'pnotify'];

  /* @ngInject */
  function CodigoPostal(api, pnotify) {
    var resource = {
      all: obtenerCodigoPostal,
      create: crearCodigoPostal,
      show: mostrarCodigoPostal,
      update: actualizarCodigoPostal,
      delete: eliminarCodigoPostal
    };
    return resource;

    ////////////////

    function obtenerCodigoPostal() {
      return api.get('/codigo-postal')
        .then(obtenerComplete)
        .catch(obtenerFailed);

      function obtenerComplete(response) {
        return response.data;
      }

      function obtenerFailed(error) {
        console.error('No se pudieron obtener los codigos postales ' + error.data);
      }
    }

    function crearCodigoPostal(data) {
      return api.post('/codigo-postal', data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        return response.data.codigo_postal;
      }

      function crearFailed(error) {
        pnotify.alertList('Error', error.error, 'error');
      }
    }

    function mostrarCodigoPostal(id) {
      return api.get('/codigo-postal/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return response.data.codigo_postal;
      }

      function mostrarFailed(error) {
        console.error('No se pudo obtener el codigo postal ' + error.error);
      }
    }

    function actualizarCodigoPostal(id, data) {
      return api.put('/codigo-postal/', id, data)
        .then(actualizarComplete)
        .catch(actualizarFailed);

      function actualizarComplete(response) {
        return response.data.message;
      }

      function actualizarFailed(error) {
        pnotify.alertList('Error', error.error, 'error');
      }
    }

    function eliminarCodigoPostal(id) {
      return api.delete('/codigo-postal/', id)
        .then(eliminarComplete)
        .catch(eliminarFailed);

      function eliminarComplete(response) {
        return response.data.message;
      }

      function eliminarFailed(response) {
        console.error(response.data.message + ' ' + JSON.stringify(response.data.error));
      }
    }
  }

})();
