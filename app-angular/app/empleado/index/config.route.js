// app/empleado/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.empleado')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('empleadoIndex', {
        url: 'empleados',
        parent: 'empleado',
        templateUrl: 'app/empleado/index/index.html',
        controller: 'empleadoIndexController',
        controllerAs: 'vm'
      });
    }
})();
