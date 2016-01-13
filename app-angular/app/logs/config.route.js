// app/logs/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.logs')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('logs', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/logs/logs.html'
      });
  }
})();
