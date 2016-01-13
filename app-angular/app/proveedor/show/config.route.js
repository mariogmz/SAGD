// app/proveedor/show/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.proveedor')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('proveedorShow', {
        url: 'proveedor/:id',
        parent: 'proveedor',
        templateUrl: 'app/proveedor/show/show.html',
        controller: 'proveedorShowController',
        controllerAs: 'vm'
      });
  }
})();
