// app/marca/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.marca')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('marca', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/marca/marca.html'
      });
  }
})();
