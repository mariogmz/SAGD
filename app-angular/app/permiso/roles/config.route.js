// app/permiso/roles/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.permiso')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('permisoRoles', {
        url: 'permisos/roles',
        parent: 'permiso',
        templateUrl: 'app/permiso/roles/roles.html',
        controller: 'permisoRolesController',
        controllerAs: 'vm'
      });
  }
})();
