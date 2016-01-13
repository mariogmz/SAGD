// app/garantia/edit/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.garantia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('garantiaEdit', {
        url: 'garantia/editar/:id',
        parent: 'garantia',
        templateUrl: 'app/garantia/edit/edit.html',
        controller: 'garantiaEditController',
        controllerAs: 'vm'
      });
  }
})();
