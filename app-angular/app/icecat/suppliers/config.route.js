// app/icecat/suppliers/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.icecat')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('icecatSuppliers', {
        url: '/fabricantes',
        parent: 'icecat',
        templateUrl: 'app/icecat/suppliers/suppliers.html',
        controller: 'icecatSuppliersController',
        controllerAs: 'vm'
      });
  }
})();
