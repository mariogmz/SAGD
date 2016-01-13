// app/margen/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.margen')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('margenIndex', {
        url: 'margen',
        parent: 'margen',
        templateUrl: 'app/margen/index/index.html',
        controller: 'margenIndexController',
        controllerAs: 'vm'
      });
  }
})();
