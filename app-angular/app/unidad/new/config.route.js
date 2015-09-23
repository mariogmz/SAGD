// app/unidad/new/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.unidad')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('unidadNew', {
        url: 'unidad/nueva',
        parent: 'unidad',
        templateUrl: 'app/unidad/new/new.html',
        controller: 'unidadNewController',
        controllerAs: 'vm'
      });
  }
})();
