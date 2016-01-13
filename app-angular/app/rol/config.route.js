// app/rol/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('rol', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/rol/rol.html'
      });
  }
})();
