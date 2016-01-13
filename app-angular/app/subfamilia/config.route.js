// app/subfamilia/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('subfamilia', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/subfamilia/subfamilia.html'
      });
  }
})();
