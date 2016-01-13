// app/familia/new/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.familia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('familiaNew', {
        url: 'familia/nueva',
        parent: 'familia',
        templateUrl: 'app/familia/new/new.html',
        controller: 'familiaNewController',
        controllerAs: 'vm'
      });
  }
})();
