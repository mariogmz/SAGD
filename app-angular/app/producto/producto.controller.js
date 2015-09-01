// app/producto/producto.controller.js

(function () {

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoController', ProductoController);

  ProductoController.$inject = ['$auth', '$state'];

  function ProductoController($auth, $state) {
    if(! $auth.isAuthenticated()){
      $state.go('login',{});
    }
  }

})();
