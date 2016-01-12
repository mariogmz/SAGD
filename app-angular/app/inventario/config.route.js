(function() {
  'use strict';

  angular
    .module('sagdApp.inventario')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('inventario', {
        url: 'inventario',
        parent: 'layout',
        templateUrl: 'app/inventario/index.html',
        controller: 'InventarioController',
        controllerAs: 'vm'
      });
  }

})();
