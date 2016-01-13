// app/subfamilia/new/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('subfamiliaNew', {
        url: 'subfamilia/nueva',
        parent: 'subfamilia',
        templateUrl: 'app/subfamilia/new/new.html',
        controller: 'subfamiliaNewController',
        controllerAs: 'vm'
      });
  }
})();
