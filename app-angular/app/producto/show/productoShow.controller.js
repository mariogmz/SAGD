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
    vm.sortKeys = [
      {name: 'Proveedor', key: 'clave'},
      {name: 'Costo', key: 'costo'},
      {name: 'P1', key: 'precio_1'},
      {name: 'P2', key: 'precio_2'},
      {name: 'P3', key: 'precio_3'},
      {name: 'P4', key: 'precio_4'},
      {name: 'P5', key: 'precio_5'},
      {name: 'P6', key: 'precio_6'},
      {name: 'P7', key: 'precio_7'},
      {name: 'P8', key: 'precio_8'},
      {name: 'P9', key: 'precio_9'},
      {name: 'P10', key: 'precio_10'},
      {name: 'Descuento', key: 'descuento'}
    ];

    vm.sort = sort;
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
          if(!vm.producto.margen){
            vm.producto.margen = {
              nombre : 'Libre'
            }
          }
          vm.precios = response.data.precios_proveedor;
          vm.producto.revisado = true;
          vm.precios.forEach(function (precio){
            vm.producto.revisado = vm.producto.revisado && precio.revisado;
          });
          return response.data;
        })
        .catch(function (response){
          vm.error = response.data;
          return response.data;
        });
    }

    function sort(keyname){
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

    function goBack() {
      window.history.back();
    }
  }
})();
