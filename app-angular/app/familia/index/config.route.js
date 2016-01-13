// app/familia/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.familia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('familiaIndex', {
        url: 'familia',
        parent: 'familia',
        templateUrl: 'app/familia/index/index.html',
        controller: 'familiaIndexController',
        controllerAs: 'vm'
      });
  }
})();
