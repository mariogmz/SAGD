// app/familia/index/margenIndex.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.familia')
    .controller('familiaIndexController', FamiliaIndexController);

  FamiliaIndexController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function FamiliaIndexController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sort = sort;
    vm.eliminarFamilia = eliminarFamilia;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Nombre', key: 'nombre'}
    ];

    initialize();

    function initialize(){
      return obtenerFamilias().then(function (){
        console.log("Familias obtenidas");
      });
    }

    function obtenerFamilias(){
      return api.get('/familia')
        .then(function (response){
          vm.familias = response.data;
          return vm.familias;
        });
    }

    function eliminarFamilia(id){
      return api.delete('/familia/', id)
        .then(function (response){
          obtenerFamilias().then(function(){
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
