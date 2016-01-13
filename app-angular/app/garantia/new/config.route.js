// app/garantia/new/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.garantia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('garantiaNew', {
        url: 'garantia/nueva',
        parent: 'garantia',
        templateUrl: 'app/garantia/new/new.html',
        controller: 'garantiaNewController',
        controllerAs: 'vm'
      });
  }
})();
