// app/producto/index/productoIndex.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoIndexController', ProductoIndexController);

  ProductoIndexController.$inject = ['$state', 'api', 'pnotify'];

  function ProductoIndexController($state, api, pnotify) {

    var vm = this;
    vm.sort = sort;
    vm.eliminarProducto = eliminarProducto;
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
    vm.searching = false;
    vm.next = goToCreateStep1;
    vm.delete = eliminarProducto;
    vm.productSearch = buscar;

    initialize();

    function initialize() {
    }

    function buscar() {
      vm.searching = !vm.searching;
      obtenerProductos().then(success).catch(error);
    }

    function obtenerProductos() {
      return api.get('/productos/buscar/', vm.search);
    }

    function eliminarProducto(id) {
      return api.delete('/producto/', id)
        .then(function(response) {
          obtenerProductos().then(function() {
            pnotify.alert('¡Exito!', response.data.message, 'success');
          });
        }).catch(function(response) {
          pnotify.alert('¡Error!', response.data.message, 'error');
        });
    }

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

    function goToCreateStep1() {
      $state.go('productoNew.step1');
    }

    function success(response) {
      vm.searching = !vm.searching;
      vm.productos = response.data;
      return response;
    }

    function error(response) {
      vm.searching = !vm.searching;
      pnotify.alert(response.data.error, response.data.message, 'error');
    }

  }

})();
