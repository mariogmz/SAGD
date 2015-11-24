// app/salida/show/config.route.js

(function() {
  'use strict';

  angular
  .module('sagdApp.salida')
  .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
    .state('salidaShow', {
      url: 'salida/:id',
      parent: 'salida',
      templateUrl: 'app/salida/show/show.html',
      controller: 'salidaShowController',
      controllerAs: 'vm'
    });
  }
})();
