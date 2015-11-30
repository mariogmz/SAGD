// app/entrada/show/config.route.js

(function() {
  'use strict';

  angular
  .module('sagdApp.entrada')
  .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
    .state('entradaShow', {
      url: 'entrada/:id',
      parent: 'entrada',
      templateUrl: 'app/entrada/show/show.html',
      controller: 'entradaShowController',
      controllerAs: 'vm'
    });
  }
})();
