// app/margen/index/margenIndex.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenIndexController', MargenIndexController);

  MargenIndexController.$inject = ['$auth', '$state', 'api'];

  function MargenIndexController($auth, $state, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sort = sort;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Nombre', key: 'nombre'},
      {name: 'Valor', key: 'valor'},
      {name: 'Webservice-P1', key: 'valor_webservice_p1'},
      {name: 'Webservice-P8', key: 'valor_webservice_p8'}
    ];

    initialize();

    function initialize() {
      return obtenerMargenes().then(function(){
        console.log("Margenes obtenidos");
      });
    }

    function obtenerMargenes() {
      return api.get('/margen')
        .then(function(response){
          vm.margenes = response.data;
          return vm.margenes;
        });
    }

    function sort(keyname){
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }

})();
