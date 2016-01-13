// app/margen/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.margen')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('margen', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/margen/margen.html'
      });
  }
})();
