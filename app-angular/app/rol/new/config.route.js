// app/rol/new/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('rolNew', {
        url: 'rol/nueva',
        parent: 'rol',
        templateUrl: 'app/rol/new/new.html',
        controller: 'rolNewController',
        controllerAs: 'vm'
      });
  }
})();
