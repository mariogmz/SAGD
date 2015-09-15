// app/producto/producto.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoController', ProductoController);

  ProductoController.$inject = ['$auth', '$state', '$http', 'api'];

  function ProductoController($auth, $state, $http, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;

    vm.obtenerProductos = function (){
      $http.get(api.endpoint + '/producto').
        then(function (response){
          vm.productos = response.data;
        }, function (response){
          vm.errors = response.data;
        });
    };

    vm.obtenerProductos();
  }

})();
