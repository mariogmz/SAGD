// app/entrada/new/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.entrada')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('entradaNew', {
        url: 'entrada/nueva',
        parent: 'entrada',
        templateUrl: 'app/entrada/new/new.html',
        controller: 'entradaNewController',
        controllerAs: 'vm'
      });
  }
})();
