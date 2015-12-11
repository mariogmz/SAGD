// app/transferencia/edit/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.transferencia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('transferenciaEdit', {
        url: 'transferencia/editar/:id',
        parent: 'transferencia',
        templateUrl: 'app/transferencia/edit/edit.html',
        controller: 'transferenciaEditController',
        controllerAs: 'vm'
      });
  }
})();
