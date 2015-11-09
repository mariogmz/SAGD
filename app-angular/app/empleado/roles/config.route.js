// app/empleado/roles/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.empleado')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('empleadoRoles', {
        url: 'empleado/:empleado/roles',
        parent: 'empleado',
        templateUrl: 'app/empleado/roles/roles.html',
        controller: 'empleadoRolesController',
        controllerAs: 'vm'
      });
    }
})();
