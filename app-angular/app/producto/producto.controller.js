// app/producto/producto.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoController', ProductoController);

  ProductoController.$inject = ['$auth', '$state', '$http'];

  function ProductoController($auth, $state, $http){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;

    vm.obtenerProductos = function (){
      $http.get('http://api.sagd.app/api/v1/producto').
        then(function (response){
          //vm.productos = response.data;
          vm.productos = [
            {
              id:1
            }
          ];
        }, function (response){
          vm.errors = response.data;
        });
    };

    vm.obtenerProductos();
  }

})();
