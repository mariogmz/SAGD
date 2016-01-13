// app/subfamilia/edit/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('subfamiliaEdit', {
        url: 'subfamilia/editar/:id',
        parent: 'subfamilia',
        templateUrl: 'app/subfamilia/edit/edit.html',
        controller: 'subfamiliaEditController',
        controllerAs: 'vm'
      });
  }
})();
