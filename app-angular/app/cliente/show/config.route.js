// app/cliente/show/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('clienteShow', {
        url: 'cliente/:id',
        parent: 'cliente',
        templateUrl: 'app/cliente/show/show.html',
        controller: 'clienteShowController',
        controllerAs: 'vm'
      });
  }
})();
