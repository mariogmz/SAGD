(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .factory('ClienteComentario', ClienteComentario);

  ClienteComentario.$inject = ['api', 'pnotify'];

  /* @ngInject */
  function ClienteComentario(api, pnotify) {
    var service = {
      all: obtenerClienteComentarioComentario,
      create: crearClienteComentario,
      show: mostrarClienteComentario,
      update: actualizarClienteComentario,
      delete: eliminarClienteComentario
    };
    return service;

    ////////////////

    function obtenerClienteComentarioComentario() {
      return api.get('/cliente-comentario')
        .then(obtenerComplete)
        .catch(obtenerFailed);

      function obtenerComplete(response) {
        return response.data;
      }

      function obtenerFailed(error) {
        console.error('No se pudieron obtener los comentarios ' + error.data);
      }
    }

    function crearClienteComentario(data) {
      return api.post('/cliente-comentario', data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.cliente_comentario;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarClienteComentario(id) {
      return api.get('/cliente-comentario/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        return formatDates(response.data.cliente_comentario);
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarClienteComentario(id, data) {
      return api.put('/cliente-comentario/', id, data)
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

    function eliminarClienteComentario(id) {
      return api.delete('/cliente-comentario/', id)
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

