// app/subfamilia/index/margenIndex.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .controller('subfamiliaIndexController', SubfamiliaIndexController);

  SubfamiliaIndexController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function SubfamiliaIndexController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sort = sort;
    vm.eliminarSubfamilia = eliminarSubfamilia;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Nombre', key: 'nombre'},
      {name: 'Familia', key: 'familia_id'},
      {name: 'Margen', key: 'margen_id'}
    ];

    initialize();

    function initialize(){
      return obtenerSubfamilias().then(function (){
        console.log("Subfamilias obtenidas");
      });
    }

    function obtenerSubfamilias(){
      return api.get('/subfamilia')
        .then(function (response){
          vm.subfamilias = response.data;
          return vm.subfamilias;
        });
    }

    function eliminarSubfamilia(id){
      return api.delete('/subfamilia/', id)
        .then(function (response){
          obtenerSubfamilias().then(function (){
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
