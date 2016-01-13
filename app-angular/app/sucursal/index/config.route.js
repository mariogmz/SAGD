// app/sucursal/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('sucursalIndex', {
        url: 'sucursal',
        parent: 'sucursal',
        templateUrl: 'app/sucursal/index/index.html',
        controller: 'sucursalIndexController',
        controllerAs: 'vm'
      });
  }
})();
