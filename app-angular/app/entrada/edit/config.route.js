// app/entrada/edit/config.route.js

(function() {
  'use strict';

  angular
  .module('sagdApp.entrada')
  .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
    .state('entradaEdit', {
      url: 'entrada/editar/:id',
      parent: 'entrada',
      templateUrl: 'app/entrada/edit/edit.html',
      controller: 'entradaEditController',
      controllerAs: 'vm'
    });
  }
})();
