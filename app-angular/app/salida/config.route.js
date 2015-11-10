// app/salida/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('salida', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/salida/salida.html'
      });
  }
})();
