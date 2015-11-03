// app/empleado/new/config.route.js

(function() {
  'use strict';

  angular
  .module('sagdApp.empleado')
  .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
    .state('empleadoNew', {
      url: 'empleado/nueva',
      parent: 'empleado',
      templateUrl: 'app/empleado/new/new.html',
      controller: 'empleadoNewController',
      controllerAs: 'vm'
    });
  }
})();
