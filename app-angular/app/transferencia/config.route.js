// app/transferencia/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.transferencia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('transferencia', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/transferencia/transferencia.html'
      });
  }
})();
