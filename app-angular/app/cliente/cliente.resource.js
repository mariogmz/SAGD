(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .factory('Cliente', Cliente);

  Cliente.$inject = ['api', 'pnotify'];

  /* @ngInject */
  function Cliente(api, pnotify) {
    var service = {
      all: obtenerClientes,
      create: crearCliente,
      show: mostrarCliente,
      update: actualizarCliente,
      delete: eliminarCliente,
      buscar: buscarCliente,
      listar: listarCliente
    };
    return service;

    ////////////////

    function obtenerClientes() {
      return api.get('/cliente')
        .then(obtenerComplete)
        .catch(obtenerFailed);

      function obtenerComplete(response) {

        return response.data;
      }

      function obtenerFailed(error) {
        console.error('No se pudieron obtener los clientes ' + error.data);
      }
    }

    function crearCliente(data) {
      return api.post('/cliente', data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        var cliente = formatDates(response.data.cliente);
        cliente.tabuladores = formatTabuladores(cliente.tabuladores);
        return cliente;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarCliente(id) {
      return api.get('/cliente/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        var cliente = formatDates(response.data.cliente);
        cliente.tabuladores = formatTabuladores(cliente.tabuladores);
        return cliente;
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarCliente(id, data) {
      return api.put('/cliente/', id, data)
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

    function eliminarCliente(id) {
      return api.delete('/cliente/', id)
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

    function buscarCliente(params) {
      return api.get('/clientes/buscar/', params)
        .then(buscarComplete)
        .catch(buscarFailed);

      function buscarComplete(response) {
        return response.data;
      }

      function buscarFailed(error) {
        pnotify.alert('Búsqueda no válida', error.data.message, 'warning');
      }
    }

    function listarCliente() {
      return api.get('/clientes/listar')
        .then(listarComplete)
        .catch(listarFailed);

      function listarComplete(response) {
        return response.data;
      }

      function listarFailed(error) {
        console.error(error.data);
      }
    }

    //////////// UTILS ////////////////

    function formatDates(cliente) {
      cliente.fecha_nacimiento = new Date(Date.parse(cliente.fecha_nacimiento));
      cliente.fecha_expira_club_zegucom = new Date(Date.parse(cliente.fecha_expira_club_zegucom));
      cliente.fecha_verificacion_correo = new Date(Date.parse(cliente.fecha_verificacion_correo));
      cliente.created_at = new Date(Date.parse(cliente.created_at));
      return cliente;
    }

    function formatTabuladores(tabuladores) {
      if (tabuladores) {
        tabuladores.forEach(function(tabulador) {
          tabulador.valor = parseInt(tabulador.valor);
          tabulador.valor_original = parseInt(tabulador.valor_original);
        });

        return tabuladores;
      } else {
        return null;
      }

    }

  }

})();
