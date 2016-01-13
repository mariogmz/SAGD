// app/producto/new/step1/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.producto')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('productoNew.step1', {
        parent: 'productoNew',
        templateUrl: 'app/producto/new/step1/step1.html',
        controller: 'productoNewStepController',
        controllerAs: 'vm'
      });
  }
})();
