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
            vm.errors = response;
          });
    };
    vm.obtenerClientes();

    vm.sort = function(keyname){
        vm.sortKey = keyname;   //set the sortKey to the param passed
        vm.reverse = !vm.reverse; //if true make it false and vice versa
    }


  }



})();
