// app/resources/ficha.resource.js
(function() {
  'use strict';

  angular
    .module('sagdApp.resources')
    .factory('Ficha', Ficha);

  Ficha.$inject = ['api'];

  /* @ngInject */
  function Ficha(api, pnotify) {
    var endpoint = '/ficha';
    var modelName = 'Ficha';

    var resource = {
      all: obtenerFichas,
      create: crearFicha,
      show: mostrarFicha,
      update: actualizarFicha,
      delete: eliminarFicha,
      completa: completa
    };
    return resource;

    //////////////////////////////////////////////////

    function obtenerFichas(calidad) {
      var endpointWithParams = endpoint + (calidad ? '/' : '');
      return api.get(endpointWithParams, calidad)
        .then(obtenerComplete)
        .catch(obtenerFailed);

      function obtenerComplete(response) {
        return response.data;
      }

      function obtenerFailed(error) {
        console.error('No se pudo obtener el recurso ' + modelName + ' ' + error.data);
      }
    }

    function crearFicha(data) {
      return api.post(endpoint, data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.ficha;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarFicha(id) {
      return api.get(endpoint + '/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return response.data.ficha;
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarFicha(id, data) {
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

    function eliminarFicha(id) {
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

    function completa(id) {
      var fullEndpoint = endpoint + '/completa/';
      return api.get(fullEndpoint, id)
        .then(completaComplete)
        .catch(completaFailed);

      function completaComplete(response) {
        console.log(response.data.message);
        return response.ficha;
      }

      function completaFailed(error) {
        console.log(error.data.message);
      }

    }

  }

})();

