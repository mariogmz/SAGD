// app/sucursal/new/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('sucursalNew', {
        url: 'sucursal/nueva',
        parent: 'sucursal',
        templateUrl: 'app/sucursal/new/new.html',
        controller: 'sucursalNewController',
        controllerAs: 'vm'
      });
  }
})();
