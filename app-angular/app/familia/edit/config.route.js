// app/familia/edit/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.familia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('familiaEdit', {
        url: 'familia/editar/:id',
        parent: 'familia',
        templateUrl: 'app/familia/edit/edit.html',
        controller: 'familiaEditController',
        controllerAs: 'vm'
      });
  }
})();
