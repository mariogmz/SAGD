// app/entrada/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.entrada')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('entrada', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/entrada/entrada.html'
      });
  }
})();
