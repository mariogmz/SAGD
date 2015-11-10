// app/rol/edit/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('rolEdit', {
        url: 'rol/editar/:id',
        parent: 'rol',
        templateUrl: 'app/rol/edit/edit.html',
        controller: 'rolEditController',
        controllerAs: 'vm'
      });
  }
})();
