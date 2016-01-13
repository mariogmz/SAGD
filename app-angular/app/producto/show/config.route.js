// app/producto/show/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.producto')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('productoShow', {
        url: 'producto/:id',
        parent: 'producto',
        templateUrl: 'app/producto/show/show.html',
        controller: 'productoShowController',
        controllerAs: 'vm'
      });
  }
})();
