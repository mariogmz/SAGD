// app/garantia/show/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.garantia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('garantiaShow', {
        url: 'garantia/:id',
        parent: 'garantia',
        templateUrl: 'app/garantia/show/show.html',
        controller: 'garantiaShowController',
        controllerAs: 'vm'
      });
  }
})();
