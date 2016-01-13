// app/permiso/individuales/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.permiso')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('permisoIndividuales', {
        url: 'permisos/individuales',
        parent: 'permiso',
        templateUrl: 'app/permiso/individuales/individuales.html',
        controller: 'permisoIndividualesController',
        controllerAs: 'vm'
      });
  }
})();
