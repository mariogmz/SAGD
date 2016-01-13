// app/transferencia/show/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.transferencia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('transferenciaShow', {
        url: 'transferencia/:id',
        parent: 'transferencia',
        templateUrl: 'app/transferencia/show/show.html',
        controller: 'transferenciaShowController',
        controllerAs: 'vm'
      });
  }
})();
