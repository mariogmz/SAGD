// app/producto/show/details/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.producto')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('productoShow.details', {
        parent: 'productoShow',
        views: {
          'datos-generales': {
            templateUrl: 'app/producto/show/details/datos-generales.html'
          },
          'peso-dimensiones': {
            templateUrl: 'app/producto/show/details/peso-dimensiones.html'
          },
          precios: {
            templateUrl: 'app/producto/show/details/precios.html'
          },
          movimientos: {
            templateUrl: 'app/producto/show/details/movimientos.html'
          },
          existencias: {
            templateUrl: 'app/producto/show/details/existencias.html'
          }
        }
      });
  }
})();
