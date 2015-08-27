// app/dashboard/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.dashboard')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
      $stateProvider
          .state('dashboard', {
              url: 'dashboard',
              parent: 'layout',
              templateUrl: 'app/dashboard/dashboard.html',
              controller: 'DashboardController',
              controllerAs: 'vm'
          });
    }
})();
