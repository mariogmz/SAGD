// app/empleado/edit/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.empleado')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('empleadoEdit', {
        url: 'empleado/editar/:id',
        parent: 'empleado',
        templateUrl: 'app/empleado/edit/edit.html',
        controller: 'empleadoEditController',
        controllerAs: 'vm'
      });
  }
})();
