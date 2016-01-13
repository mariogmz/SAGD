// app/subfamilia/show/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('subfamiliaShow', {
        url: 'subfamilia/:id',
        parent: 'subfamilia',
        templateUrl: 'app/subfamilia/show/show.html',
        controller: 'subfamiliaShowController',
        controllerAs: 'vm'
      });
  }
})();
