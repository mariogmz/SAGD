// app/margen/new/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.margen')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('margenNew', {
        url: 'margen/nueva',
        parent: 'margen',
        templateUrl: 'app/margen/new/new.html',
        controller: 'margenNewController',
        controllerAs: 'vm'
      });
  }
})();
