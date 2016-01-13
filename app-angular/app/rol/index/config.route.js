// app/rol/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('rolIndex', {
        url: 'roles',
        parent: 'rol',
        templateUrl: 'app/rol/index/index.html',
        controller: 'rolIndexController',
        controllerAs: 'vm'
      });
  }
})();
