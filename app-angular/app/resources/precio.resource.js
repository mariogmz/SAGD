// app/resources/precio.resource.js
(function() {
  'use strict';

  angular
    .module('sagdApp.resources')
    .factory('Precio', Precio);

  Precio.$inject = ['api'];

  /* @ngInject */
  function Precio(api, pnotify) {
    var endpoint = '/precio';
    var modelName = 'Precio';

    var resource = {
      calcular: calcular
    };
    return resource;

    //////////////////////////////////////////////////

    function obtenerPrecios() {
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

    function crearPrecio(data) {
      return api.post(endpoint, data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.precio;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarPrecio(id) {
      return api.get(endpoint + '/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return response.data.precio;
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarPrecio(id, data) {
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

    function eliminarPrecio(id) {
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

    function calcular(params) {
      return api.get('/calcular-precio', params)
        .then(calcularComplete)
        .catch(calcularFailed);

      function calcularComplete(response) {
        console.log(response.data.message);
        return response.data.resultado;
      }

      function calcularFailed(error) {
        pnotify.alertList(error.data.message, error.data.errors, 'error');
      }
    }

  }

})();

