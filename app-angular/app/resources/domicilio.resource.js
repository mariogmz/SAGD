// app/blocks/domicilio/domicilio.resource.js

(function() {
  'use strict';

  angular
    .module('blocks.resources')
    .factory('Domicilio', Domicilio);

  Domicilio.$inject = ['api', 'pnotify'];

  /* @ngInject */
  function Domicilio(api, pnotify) {
    var resource = {
      all: obtenerDomicilios,
      create: crearDomicilio,
      show: mostrarDomicilio,
      update: actualizarDomicilio,
      delete: eliminarDomicilio
    };
    return resource;

    ////////////////

    function obtenerDomicilios() {
      return api.get('/domicilio')
        .then(obtenerComplete)
        .catch(obtenerFailed);

      function obtenerComplete(response) {
        return response.data;
      }

      function obtenerFailed(error) {
        console.error('No se pudieron obtener los domicilios ' + error.data);
      }
    }

    function crearDomicilio(data) {
      return api.post('/domicilio', data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        return response.data.domicilio;
      }

      function crearFailed(error) {
        pnotify.alertList('Error', error.error, 'error');
      }
    }

    function mostrarDomicilio(id) {
      return api.get('/domicilio/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return response.data.domicilio;
      }

      function mostrarFailed(error) {
        console.error('No se pudo obtener el domicilio ' + error.error);
      }
    }

    function actualizarDomicilio(id, data) {
      return api.put('/domicilio/', id, data)
        .then(actualizarComplete)
        .catch(actualizarFailed);

      function actualizarComplete(response) {
        return response.data.message;
      }

      function actualizarFailed(error) {
        pnotify.alertList('Error', error.error, 'error');
      }
    }

    function eliminarDomicilio(id) {
      return api.delete('/domicilio/', id)
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
