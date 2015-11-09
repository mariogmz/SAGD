// app/rol/empleados/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('rolEmpleados', {
        url: 'rol/:rol/empleados',
        parent: 'rol',
        templateUrl: 'app/rol/empleados/empleados.html',
        controller: 'rolEmpleadosController',
        controllerAs: 'vm'
      });
    }
})();
