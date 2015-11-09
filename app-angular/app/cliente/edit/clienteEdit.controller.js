// app/cliente/clienteEdit.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteEditController', ClienteEditController);

  ClienteEditController.$inject = ['$state', '$stateParams', '$location', 'api', 'pnotify'];

  function ClienteEditController($state, $stateParams, $location, api, pnotify){

    var vm = this;

    vm.id = $stateParams.id;
    vm.save = save;
    vm.selectTab = selectTab;
    vm.tab = "datos-generales";

    function obtenerCliente(){
      return api.get('/cliente/', vm.id)
          .then(function (response){
            vm.cliente = response.data.cliente;
            return response.data;
          })
          .catch(function (response){
            vm.error = response.data;
            return response.data;
          });
    }

    activate();

    function activate() {
      obtenerCliente()
          .then(obtenerReferencias)
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

    function save(){

      return api.put('/cliente/', vm.cliente.id, vm.cliente)
      .then(function (response){
            vm.message = response.data.message;
            pnotify.alert('Exito', vm.message, 'success');
            $state.go('clienteShow', {id: vm.cliente.id});

          })
          .catch(function (response){
            vm.error = response.data;
            pnotify.alertList('No se pudo modificar el cliente', vm.error.error, 'error');
            return response;
         });
    }

    function selectTab(tab){
      this.tab = tab;
    }

  }

})();
