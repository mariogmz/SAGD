// app/producto/show/producto.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoShowController', ProductoShowController);

  ProductoShowController.$inject = ['$auth', '$state', '$stateParams', 'api'];

  function ProductoShowController($auth, $state, $stateParams, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

    initialize();

    function initialize(){
      return obtenerProducto().then(function (){
        console.log('Producto obtenido correctamente.');
        $state.go('productoShow.details');
      });
    }

    function obtenerProducto(){
      return api.get('/producto/', vm.id)
        .then(function (response){
          vm.producto = response.data.producto;
          vm.precio = response.data.precios_proveedor;
          return response.data;
        })
        .catch(function (response){
          vm.error = response.data;
          return response.data;
        });
    }

    function goBack() {
      window.history.back();
    }
  }
})();
