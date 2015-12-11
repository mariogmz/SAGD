// app/transferencia/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.transferencia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('transferenciaIndex', {
        url: 'transferencias',
        parent: 'transferencia',
        templateUrl: 'app/transferencia/index/index.html',
        controller: 'transferenciaIndexController',
        controllerAs: 'vm'
      });
  }
})();
