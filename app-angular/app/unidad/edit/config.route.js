// app/unidad/edit/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.unidad')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('unidadEdit', {
        url: 'unidad/editar/:id',
        parent: 'unidad',
        templateUrl: 'app/unidad/edit/edit.html',
        controller: 'unidadEditController',
        controllerAs: 'vm'
      });
  }
})();
