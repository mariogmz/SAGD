// app/producto/edit/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.producto')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('productoEdit', {
        url: 'producto/editar/:id',
        parent: 'producto',
        templateUrl: 'app/producto/edit/edit.html',
        controller: 'productoEditController',
        controllerAs: 'vm'
      });
  }
})();
