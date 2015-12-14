// app/transferencia/carga/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.transferencia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('transferenciaCarga', {
        url: 'transferencia/cargar/:id',
        parent: 'transferencia',
        templateUrl: 'app/transferencia/carga/carga.html',
        controller: 'transferenciaCargaController',
        controllerAs: 'vm'
      });
  }
})();
