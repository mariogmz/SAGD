// app/salida/edit/config.route.js

(function() {
  'use strict';

  angular
  .module('sagdApp.salida')
  .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
    .state('salidaEdit', {
      url: 'salida/editar/:id',
      parent: 'salida',
      templateUrl: 'app/salida/edit/edit.html',
      controller: 'salidaEditController',
      controllerAs: 'vm'
    });
  }
})();
