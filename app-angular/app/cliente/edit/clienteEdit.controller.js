// app/cliente/edit/clienteEdit.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteEditController', ClienteEditController);

  ClienteEditController.$inject = ['$state', '$stateParams', 'api', 'pnotify'];

  function ClienteEditController($state, $stateParams, api, pnotify) {

    var vm = this;
    vm.id = $stateParams.id;

    ///////////////////////////////////

    activate();

    function activate() {

      obtenerCliente()
        .then(function() {
          $state.go('details');
        })
        .then(obtenerEmpleados)
        .then(obtenerReferencias)
        .then(obtenerRoles)
        .then(obtenerEstatus)
        .then(obtenerSucursales);
    }

    function obtenerCliente() {
      return api.get('/cliente/', vm.id)
        .then(function(response) {
          vm.cliente = formatDates(response.data.cliente);
          console.log('Cliente ' + vm.cliente.nombre + ' obtenido');
        })
        .catch(function(response) {
          vm.cliente = {};
          console.error(response.data.message);
        });
    }

    function obtenerEmpleados() {
      return api.get('/empleado')
        .then(function(response) {
          vm.empleados = response.data;
          console.log('Empleados obtenidos correctamente.');
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
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('Hubo un problema al obtener los Estatus', vm.error.error, 'error');
          return response;
        });
    }

    function obtenerSucursales() {
      return api.get('/sucursal')
        .then(function(response) {
          vm.sucursales = response.data.filter(function(sucursal){
            return !sucursal.proveedor.externo;
          });

          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('Hubo un problema al obtener las Sucursales', vm.error.error, 'error');
          return response;
        });
    }

    //////////// UTILS ////////////////

    function formatDates(cliente) {
      cliente.fecha_nacimiento = new Date(Date.parse(cliente.fecha_nacimiento));
      cliente.fecha_expira_club_zegucom = new Date(Date.parse(cliente.fecha_expira_club_zegucom));
      cliente.fecha_verificacion_correo = new Date(Date.parse(cliente.fecha_verificacion_correo));
      cliente.created_at = new Date(Date.parse(cliente.created_at));
      return cliente;
    }
  }

})();
