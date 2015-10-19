// app/revisar-precios/show/revisarPrecios.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.revisarPrecios')
    .controller('revisarPreciosController', RevisarPreciosController);

  RevisarPreciosController.$inject = ['$auth', '$state', 'api'];

  function RevisarPreciosController($auth, $state, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'UPC', key: 'upc'},
      {name: 'Num. Parte', key: 'numero_parte'},
      {name: 'Descripción', key: 'descripcion'}
    ];

    vm.sort = sort;

    initialize();

    function initialize(){
      return obtenerProducto().then(function (){
        console.log('Productos obtenidos correctamente.');
      });
    }

    function obtenerProducto(){
      return api.get('/producto/', [{key: 'revisados', value: false}])
        .then(function (response){
          vm.productos = response.data;
          return response.data;
        })
        .catch(function (response){
          console.log('Hubo un error al obtener los productos.')
        });
    }

    function sort(keyname){
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }
})();
