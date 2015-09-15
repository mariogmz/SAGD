// app/margen/show/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenShowController', MargenShowController);

  MargenShowController.$inject = ['$auth', '$state', '$stateParams', '$http', 'api'];

  function MargenShowController($auth, $state, $stateParams, $http, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;

    initialize();

    function initialize(){
      return obtenerMargen().then(function(response){
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
  }

})();
