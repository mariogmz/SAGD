// app/producto/index/productoIndex.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoIndexController', ProductoIndexController);

  ProductoIndexController.$inject = ['$state', 'Producto', 'pnotify'];

  /* @ngInject */
  function ProductoIndexController($state, Producto, pnotify) {

    var vm = this;
    vm.eliminar = eliminar;
    vm.buscar = buscar;
    vm.goToNew = goToNew;
    vm.sort = sort;

    initialize();

    function initialize() {
      vm.sortKeys = [
        {name: '#', key: 'id'},
        {name: 'Clave', key: 'clave'},
        {name: 'UPC', key: 'upc'},
        {name: 'Descripción', key: 'descripcion'},
        {name: 'Num. Parte', key: 'numero_parte'}
      ];
      vm.search = {
        clave: '',
        descripcion: '',
        numero_parte: '',
        upc: ''
      };
      vm.conExistencias = 1;
      vm.searching = false;
    }

    //////////////// API CALLS //////////////////
    function obtenerProductos() {
      return Producto.buscar(vm.search.clave, vm.search.descripcion, vm.search.numero_parte, vm.search.upc,
        vm.conExistencias);
    }

    function eliminarProducto(id) {
      return Producto.delete(id)
        .then(function(data) {
          if (data) {
            pnotify.alert('¡Exito!', response.data.message, 'success');
          }

          return data;
        });
    }

    /////////////// UI Behavior ////////////////

    function buscar() {
      vm.searching = !vm.searching;
      return obtenerProductos()
        .then(function(productos) {
          if (productos) {
            vm.productos = productos;
          }

          vm.searching = !vm.searching;
          return productos;
        });
    }

    function eliminar(id) {
      return eliminarProducto(id)
        .then(buscar);
    }

    /////////////////// UTILS //////////////////

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

    function goToNew() {
      $state.go('productoNew.step1');
    }

  }

})();
