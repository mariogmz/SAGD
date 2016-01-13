// app/proveedor/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.proveedor')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('proveedorIndex', {
        url: 'proveedor',
        parent: 'proveedor',
        templateUrl: 'app/proveedor/index/index.html',
        controller: 'proveedorIndexController',
        controllerAs: 'vm'
      });
  }
})();
