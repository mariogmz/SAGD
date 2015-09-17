// app/proveedor/proveedor.controller.js

(function () {
  'use strict';

  angular
      .module('sagdApp.proveedor')
      .controller("proveedorController", ProveedorController);

  ProveedorController.$inject = ['$auth', '$state', '$http'];

  function ProveedorController($auth, $state, $http) {
    if(! $auth.isAuthenticated()){
      $state.go('login', {});
    }
    var vm = this;

    vm.obtenerProveedores = function (){
      $http.get('http://api.sagd.app/api/v1/proveedor').
          then(function (response){
            vm.proveedores = response.data;
          }, function (response){
            vm.errors = response;
          });
    };
    vm.obtenerProveedores();

    vm.sort = function(keyname){
        vm.sortKey = keyname;   //set the sortKey to the param passed
        vm.reverse = !vm.reverse; //if true make it false and vice versa
    }


  }



})();
