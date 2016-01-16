// app/resources/marca.resource.js
(function() {
  'use strict';

  angular
    .module('sagdApp.resources')
    .factory('Marca', Marca);

  Marca.$inject = ['api'];

  /* @ngInject */
  function Marca(api, pnotify) {
    var endpoint = '/marca';
    var modelName = 'Marca';

    var resource = {
      all: obtenerMarcas,
      create: crearMarca,
      show: mostrarMarca,
      update: actualizarMarca,
      delete: eliminarMarca
    };
    return resource;

    //////////////////////////////////////////////////

    function obtenerMarcas() {
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

    function crearMarca(data) {
      return api.post(endpoint, data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.marca;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarMarca(id) {
      return api.get(endpoint + '/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return response.data.marca;
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarMarca(id, data) {
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

    function eliminarMarca(id) {
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

