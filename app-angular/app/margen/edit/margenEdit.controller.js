// app/margen/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenEditController', MargenEditController);

  MargenEditController.$inject = ['$auth', '$state', '$http', '$stateParams', 'api'];

  function MargenEditController($auth, $state, $http, $stateParams, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;

    vm.save = guardarMargen;
    vm.clean = limpiar;

    initialize();

    function initialize() {
      return obtenerMargen('/margen/', vm.id).then(function(response){
        console.log(response.message);
      });
    }

    function obtenerMargen() {
      return api.get('/margen/', vm.id)
        .then(function(response){
          vm.margen = response.data.margen;
          return response.data;
        })
        .catch(function(response){
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarMargen() {
      return api.put('/margen/', vm.id, vm.margen)
        .then(function(response){
          vm.message = response.data.message;
          vm.error = false;
          return response;
        })
        .catch(function(response){
          vm.error = response;
          return response;
        });
    }

    function limpiar () {
      vm.message = null;
      vm.error = null;
    };
  }

})();
