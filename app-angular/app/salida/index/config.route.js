// app/salida/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('salidaIndex', {
        url: 'salidas',
        parent: 'salida',
        templateUrl: 'app/salida/index/index.html',
        controller: 'salidaIndexController',
        controllerAs: 'vm'
      });
  }
})();
