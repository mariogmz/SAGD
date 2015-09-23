// app/unidad/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.unidad')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('unidadIndex', {
        url: 'unidad',
        parent: 'unidad',
        templateUrl: 'app/unidad/index/index.html',
        controller: 'unidadIndexController',
        controllerAs: 'vm'
      });
  }
})();
