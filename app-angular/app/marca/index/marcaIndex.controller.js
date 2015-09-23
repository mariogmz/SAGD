// app/marca/index/margenIndex.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.marca')
    .controller('marcaIndexController', MarcaIndexController);

  MarcaIndexController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function MarcaIndexController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sort = sort;
    vm.eliminarMarca = eliminarMarca;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Nombre', key: 'nombre'}
    ];

    initialize();

    function initialize(){
      return obtenerMarcas().then(function (){
        console.log("Marcas obtenidas");
      });
    }

    function obtenerMarcas(){
      return api.get('/marca')
        .then(function (response){
          vm.marcas = response.data;
          return vm.marcas;
        });
    }

    function eliminarMarca(id){
      return api.delete('/marca/', id)
        .then(function (response){
          obtenerMarcas().then(function(){
            pnotify.alert('¡Exito!', response.data.message, 'success');
          });
        }).catch(function (response){
          pnotify.alert('¡Error!', response.data.message, 'error');
        });
    }

    function sort(keyname){
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

  }

})();
