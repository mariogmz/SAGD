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
        .then(obtenerRoles)
        .then(obtenerSucursales);
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

    function selectTab(tab){
      this.tab = tab;
    }

    function goBack() {
      window.history.back();
    }
  }



})
();
