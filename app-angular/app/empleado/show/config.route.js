// app/empleado/show/config.route.js

(function() {
  'use strict';

  angular
  .module('sagdApp.empleado')
  .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
    .state('empleadoShow', {
      url: 'empleado/:id',
      parent: 'empleado',
      templateUrl: 'app/empleado/show/show.html',
      controller: 'empleadoShowController',
      controllerAs: 'vm'
    });
  }
})();
