// app/entrada/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.entrada')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('entradaIndex', {
        url: 'entradas',
        parent: 'entrada',
        templateUrl: 'app/entrada/index/index.html',
        controller: 'entradaIndexController',
        controllerAs: 'vm'
      });
  }
})();
