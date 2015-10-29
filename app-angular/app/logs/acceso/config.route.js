// app/logs/acceso/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.logs')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('logsAcceso', {
        url: 'logs/acceso',
        parent: 'logs',
        templateUrl: 'app/logs/acceso/acceso.html',
        controller: 'logsAccesoController',
        controllerAs: 'vm'
      });
  }
})();
