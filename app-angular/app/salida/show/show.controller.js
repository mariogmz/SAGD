// app/salida/show/show.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .controller('salidaShowController', salidaShowController);

  salidaShowController.$inject = ['$stateParams', 'api'];

  /* @ngInject */
  function salidaShowController($stateParams, api) {

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
      window.history.back();
    }
  }
})();
