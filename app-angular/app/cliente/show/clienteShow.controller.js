// app/cliente/show/cliente.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteShowController', ClienteShowController);

  ClienteShowController.$inject = ['$auth', '$state', '$stateParams', 'api', 'pnotify'];



  function ClienteShowController($auth, $state, $stateParams, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;
    vm.selectTab = selectTab;
    vm.tab = "datos-generales";

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
      return api.get('/cliente-referencia/', vm.cliente.referencia_id)
          .then(function (response) {
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
      return api.get('/cliente-estatus/', vm.cliente.estatus_id)
          .then(function (response) {
            vm.estatus = response.data;
            console.log('Estatus obtenido correctamente');
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener los Estatus', vm.error.error, 'error');
            return response;
          });
    }

    function obtenerEpleados() {
      return api.get('/empleado/', vm.cliente.empleado_id)
          .then(function (response) {
            vm.empleados = response.data;
            console.log('Empleado obtenido correctamente');
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener los Empleados', vm.error.error, 'error');
            return response;
          });
    }

    function obtenerRoles() {
      return api.get('/rol/', vm.cliente.rol_id)
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
      return api.get('/sucursal/', vm.cliente.sucursal_id)
          .then(function (response) {
            vm.sucursales = response.data;
            console.log('Sucursal obtenida correctamente');
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener las Sucursales', vm.error.error, 'error');
            return response;
          });
    }

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

    function selectTab(tab){
      this.tab = tab;
    }

    function goBack() {
      window.history.back();
    }
  }



})
();
