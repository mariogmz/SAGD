// app/producto/edit/details/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.producto')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('productoEdit.details', {
        parent: 'productoEdit',
        views: {
          'datos-generales': {
            templateUrl: 'app/producto/edit/details/datos-generales.html'
          },
          ficha: {
            templateUrl: 'app/producto/edit/details/ficha.html'
          },
          'precios-existencias': {
            templateUrl: 'app/producto/edit/details/precios-existencias.html'
          },
          movimientos: {
            templateUrl: 'app/producto/edit/details/movimientos.html'
          }
        }
      });
  }
})();
