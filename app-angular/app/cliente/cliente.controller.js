// app/cliente/cliente.controller.js

(function () {
  'use strict';

  angular
      .module('sagdApp.cliente')
      .controller("clienteController", ClienteController);

  ClienteController.$inject = ['$auth', '$state', '$http'];

  function ClienteController($auth, $state, $http) {
    if(! $auth.isAuthenticated()){
      $state.go('login', {});
    }
    var vm = this;

    vm.obtenerClientes = function (){
      $http.get('http://api.sagd.app/api/v1/cliente').
          then(function (response){
            vm.clientes = response.data;
          }, function (response){
            vm.errors = response.data;
          });
    };

    vm.obtenerClientes();



  }



})();
