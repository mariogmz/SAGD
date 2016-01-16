// app/resources/unidad.resource.js
(function() {
  'use strict';

  angular
    .module('sagdApp.resources')
    .factory('Unidad', Unidad);

  Unidad.$inject = ['api'];

  /* @ngInject */
  function Unidad(api, pnotify) {
    var endpoint = '/unidad';
    var modelName = 'Unidad';

    var resource = {
      all: obtenerUnidades,
      create: crearUnidad,
      show: mostrarUnidad,
      update: actualizarUnidad,
      delete: eliminarUnidad
    };
    return resource;

    //////////////////////////////////////////////////

    function obtenerUnidades() {
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

    function crearUnidad(data) {
      return api.post(endpoint, data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.unidad;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarUnidad(id) {
      return api.get(endpoint + '/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return response.data.unidad;
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarUnidad(id, data) {
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

    function eliminarUnidad(id) {
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

