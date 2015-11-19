// app/salida/show/show.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .controller('salidaShowController', salidaShowController);

  salidaShowController.$inject = ['$state', '$stateParams', 'api'];

  /* @ngInject */
  function salidaShowController($state, $stateParams, api) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

    activate();

    ////////////////

    function activate() {
      return obtenerSalida().then(function(response) {
          console.log(response.message);
        });
    }

    function obtenerSalida() {
      return api.get('/salida/', vm.id).then(function(response) {
        vm.salida = response.data.salida;
        return response.data;
      })
      .catch(function(response) {
        vm.error = response.data;
        return response.data;
      });
    }

    function goBack() {
      $state.go('salidaIndex');
    }
  }
})();
