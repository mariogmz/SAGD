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
    vm.margenes = [];

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
  }

})();
