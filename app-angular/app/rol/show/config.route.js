// app/rol/show/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('rolShow', {
        url: 'rol/:id',
        parent: 'rol',
        templateUrl: 'app/rol/show/show.html',
        controller: 'rolShowController',
        controllerAs: 'vm'
      });
  }
})();
