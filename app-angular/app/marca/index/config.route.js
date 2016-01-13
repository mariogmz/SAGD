// app/marca/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.marca')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('marcaIndex', {
        url: 'marca',
        parent: 'marca',
        templateUrl: 'app/marca/index/index.html',
        controller: 'marcaIndexController',
        controllerAs: 'vm'
      });
  }
})();
