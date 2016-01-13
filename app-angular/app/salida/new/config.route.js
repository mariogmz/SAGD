// app/salida/new/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('salidaNew', {
        url: 'salida/nueva',
        parent: 'salida',
        templateUrl: 'app/salida/new/new.html',
        controller: 'salidaNewController',
        controllerAs: 'vm'
      });
  }
})();
