// app/transferencia/show/show.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.transferencia')
    .controller('transferenciaShowController', transferenciaShowController);

  transferenciaShowController.$inject = ['$stateParams', 'api'];

  /* @ngInject */
  function transferenciaShowController($stateParams, api) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

    activate();

    ////////////////

    function activate() {
      obtenerTransferencia().then(function(response) {
        console.log('Transferencia obtenida exitosamente');
        vm.transferencia = response.data.transferencia;
      });
    }

    function obtenerTransferencia() {
      return api.get('/transferencias/salidas/ver/' + vm.id);
    }

    function goBack() {
      window.history.back();
    }
  }
})();
