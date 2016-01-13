// app/home/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.home')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('home', {
        url: '',
        parent: 'layout',
        templateUrl: 'app/home/home.html',
        controller: 'HomeController',
        controllerAs: 'vm'
      });
  }
})();
