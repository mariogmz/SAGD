// app/cliente/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('clienteIndex', {
        url: 'cliente',
        parent: 'cliente',
        templateUrl: 'app/cliente/index/index.html',
        controller: 'clienteIndexController',
        controllerAs: 'vm'
      });
  }
})();
