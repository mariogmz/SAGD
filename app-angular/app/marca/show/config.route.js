// app/marca/show/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.marca')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('marcaShow', {
        url: 'marca/:id',
        parent: 'marca',
        templateUrl: 'app/marca/show/show.html',
        controller: 'marcaShowController',
        controllerAs: 'vm'
      });
  }
})();
