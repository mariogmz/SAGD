// app/layout/config.route.js

(function () {
  'use strict';

  angular
    .module('sagdApp.layout')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('layout', {
        url: '/',
        templateUrl: 'app/layout/layout.html',
        abstract: true,
        controller: 'layoutController',
        controllerAs: 'vm'
      });
  }
})();
