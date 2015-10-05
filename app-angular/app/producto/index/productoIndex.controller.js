// app/producto/index/margenIndex.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoIndexController', ProductoIndexController);

  ProductoIndexController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function ProductoIndexController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sort = sort;
    vm.eliminarProducto = eliminarProducto;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Descripción', key: 'descripcion'},
      {name: 'Número de parte', key: 'numero_parte'},
      {name: 'Subfamilia', key: 'subfamilia.clave'}
    ];
    vm.next = goToCreateStep1;

    initialize();

    function initialize(){
      return obtenerProductos().then(function (){
        console.log("Productos obtenidos");
      });
    }

    function obtenerProductos(){
      return api.get('/producto')
        .then(function (response){
          vm.productos = response.data;
          return vm.productos;
        });
    }

    function eliminarProducto(id){
      return api.delete('/producto/', id)
        .then(function (response){
          pnotify.alert('¡Exito!', response.data.message, 'success');
        }).catch(function (response){
          pnotify.alert('¡Error!', response.data.message, 'error');
        });
    }

    function sort(keyname){
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

    function goToCreateStep1(){
      $state.go('productoNew.step1');
    }

  }

})();
