// app/sucursal/show/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('sucursalShow', {
        url: 'sucursal/:id',
        parent: 'sucursal',
        templateUrl: 'app/sucursal/show/show.html',
        controller: 'sucursalShowController',
        controllerAs: 'vm'
      });
  }
})();
