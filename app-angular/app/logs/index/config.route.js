// app/logs/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.logs')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('logsIndex', {
        url: 'logs',
        parent: 'logs',
        templateUrl: 'app/logs/index/index.html',
        controller: 'logsIndexController',
        controllerAs: 'vm'
      });
  }
})();
