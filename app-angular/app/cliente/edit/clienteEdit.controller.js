// app/cliente/edit/clienteEdit.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteEditController', ClienteEditController);

  ClienteEditController.$inject = ['$state', '$stateParams', 'api', 'pnotify', 'Cliente', 'ClienteComentario', 'utils'];

  function ClienteEditController($state, $stateParams, api, pnotify, Cliente, ClienteComentario, utils) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.empleado = {};
    vm.save = guardarCambios;
    vm.setClass = utils.setClass;
    vm.agregarComentario = agregarComentario;
    vm.guardarComentario = guardarComentario;
    vm.eliminarComentario = eliminarComentario;

    ///////////////////////////////////

    activate();

    function activate() {

      obtenerCliente()
        .then(function() {
          vm.empleado = JSON.parse(localStorage.getItem('empleado'));
          utils.whichTab($location.hash() || 'datos-generales');
          return $state.go('clienteEdit.details');
        })
        .then(obtenerEmpleados)
        .then(obtenerReferencias)
        .then(obtenerRoles)
        .then(obtenerEstatus)
        .then(obtenerSucursales);
    }

    /////////////// Get resources ///////////////

    function obtenerCliente() {
      return Cliente.show(vm.id)
        .then(function(cliente) {
          vm.cliente = cliente;
          console.log('Cliente ' + cliente.nombre + ' obtenido');
          return cliente;
        });
    }

    function obtenerEmpleados() {
      return api.get('/empleado')
        .then(function(response) {
          vm.empleados = response.data;
          console.log('Empleados obtenidos correctamente.');
          return response.data;
        })
        .catch(function(response) {
          console.log('No se pudieron obtener los empleados', response.data);
        });
    }

    function obtenerReferencias() {
      return api.get('/cliente-referencia')
        .then(function(response) {
          vm.clientes_referencias = response.data;
          console.log('Catálogo de referencias obtenido correctamente.');
          return response.data;
        })
        .catch(function(response) {
          console.log('No se pudo obtener el catálogo de referencias.');
        });
    }

    function obtenerRoles() {
      return api.get('/roles/clientes')
        .then(function(response) {
          vm.roles = response.data;
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('Hubo un problema al obtener los Roles', vm.error.message, 'error');
          return response;
        });
    }

    function obtenerEstatus() {
      return api.get('/cliente-estatus')
        .then(function(response) {
          vm.estatus = response.data;
          return response.data;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('Hubo un problema al obtener los Estatus', vm.error.error, 'error');
        });
    }

    function obtenerSucursales() {
      return api.get('/sucursal')
        .then(function(response) {
          vm.sucursales = response.data.filter(function(sucursal) {
            return !sucursal.proveedor.externo;
          });

          return response.data;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('Hubo un problema al obtener las Sucursales', vm.error.error, 'error');
        });
    }

    ////////////// Saves and updates /////////////

    function guardarCambios(valid) {
      if (valid) {
        return actualizarCliente()
          .then(function(data) {
            $state.go('clienteShow', {id: vm.id});
            return data;
          });
      }
    }

    function actualizarCliente() {
      return Cliente.update(vm.id, vm.cliente)
        .then(function(data) {
          return data;
        });
    }

    function agregarComentario() {
      if (!vm.cliente.comentarios) {
        vm.cliente.comentarios = [];
      }

      vm.cliente.comentarios.push({
        empleado: {
          usuario: vm.empleado.usuario
        }
      });
    }

    function guardarComentario(comentario) {
      comentario.empleado_id = vm.empleado.id;
      if (!comentario.id) {
        comentario.cliente_id = vm.cliente.id;
        return ClienteComentario.create(comentario)
          .then(function(data) {
            return data;
          });
      } else {
        return ClienteComentario.update(comentario.id, comentario)
          .then(function(comentarioNuevo) {
            comentario.empleado.usuario = vm.empleado.usuario;
            return comentarioNuevo;
          });
      }
    }

    function eliminarComentario(comentario) {
      var index = vm.cliente.comentarios.indexOf(comentario);
      vm.cliente.comentarios.splice(index, 1);
      if (comentario.id) {
        return ClienteComentario.delete(comentario.id);
      }

    }
  }

})();
