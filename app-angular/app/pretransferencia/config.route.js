// app/pretransferencia/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.pretransferencia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('pretransferencia', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/pretransferencia/pretransferencia.html'
      });
  }
})();
