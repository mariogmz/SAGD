// app/garantia/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.garantia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('garantiaIndex', {
        url: 'garantia',
        parent: 'garantia',
        templateUrl: 'app/garantia/index/index.html',
        controller: 'garantiaIndexController',
        controllerAs: 'vm'
      });
  }
})();
