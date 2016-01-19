// app/producto/show/producto.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoShowController', ProductoShowController);

  ProductoShowController.$inject = ['$location', '$state', '$stateParams', 'api', 'session', 'utils', 'Producto', 'Ficha'];

  /* @ngInject */
  function ProductoShowController($location, $state, $stateParams, api, session, utils, Producto, Ficha) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.empleado = session.obtenerEmpleado();
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

    vm.back = goBack;
    vm.sort = sort;

    initialize();

    function initialize() {
      utils.whichTab($location.hash() || 'datos-generales');
      return obtenerProducto()
        .then(function(producto) {
          $state.go('productoShow.details', {id: vm.id});
          return producto;
        })
        .then(cargarFicha)
        .then(obtenerMovimientos);
    }

    ////////////////// API CALLS ///////////////////////

    function obtenerProducto() {
      return Producto.show(vm.id)
        .then(function(producto) {
          vm.producto = producto;
          return producto;
        });
    }

    function obtenerMovimientos() {
      return Producto.movimientos(vm.id, vm.empleado.sucursal_id)
        .then(function(movimientos) {
          vm.movimientos = movimientos;
          return movimientos;
        });
    }

    function cargarFicha(producto) {
      return Ficha.completa(producto.ficha.id)
        .then(function(ficha) {
          vm.ficha = ficha || {};
          return ficha;
        });
    }

    ///////////////// UTILS ///////////////////

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

    function goBack() {
      window.history.back();
    }
  }
})();
