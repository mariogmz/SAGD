// app/cliente/clienteNew.controller.js

(function (){

  'use strict';

  angular
      .module('sagdApp.cliente')
      .controller('clienteNewController', ClienteNewController);

  ClienteNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function ClienteNewController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.create = create;

    activate();

    function activate() {
      obtenerReferencias()
          .then(obtenerEstatus)
          .then(obtenerEpleados)
          .then(obtenerRoles)
          .then(obtenerSucursales);
    }

    function obtenerReferencias() {
      return api.get('/cliente-referencia').then(function (response) {
            vm.referencias = response.data;
            console.log('Referencias obtenidas correctamente');
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener las Referencias', vm.error.error, 'error');
            return response;
          });
    }

    function obtenerEstatus() {
      return api.get('/cliente-estatus')
          .then(function (response) {
            vm.estatus = response.data;
            console.log('Estatus obtenidos correctamente');
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener los Estatus', vm.error.error, 'error');
            return response;
          });
    }

    function obtenerEpleados() {
      return api.get('/empleado')
          .then(function (response) {
            vm.empleados = response.data;
            console.log('Empleados obtenidos correctamente');
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener los Empleados', vm.error.error, 'error');
            return response;
          });
    }

    function obtenerRoles() {
      return api.get('/rol')
          .then(function (response) {
            vm.roles = response.data;
            return response;
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener los Roles', vm.error.error, 'error');
            return response;
          });
    }

    function obtenerSucursales() {
      return api.get('/sucursal')
          .then(function (response) {
            vm.sucursales = response.data;
            console.log('Sucursales obtenidas correctamente');
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener las Sucursales', vm.error.error, 'error');
            return response;
          });
    }


    function create(){

      console.log("Model: " + vm.model);
      return 0;



      return api.post('/cliente', vm.model)
          .then(function (response){
            vm.message = response.data.message;
            pnotify.alert('Exito', vm.message, 'success');
            $state.go('clienteShow', {id: response.data.cliente.id});
          })
          .catch(function (response){
            vm.error = response.data;
            pnotify.alertList('No se pudo guardar el cliente', vm.error.error, 'error');
            return response;
          });
    }

  }

})();
