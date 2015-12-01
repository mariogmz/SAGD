// app/producto/edit/details/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.producto')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('productoEdit.details', {
        parent: 'productoEdit',
        views: {
          'datos-generales': {
            templateUrl: 'app/producto/edit/details/datos-generales.html'
          },
          'peso-dimensiones': {
            templateUrl: 'app/producto/edit/details/peso-dimensiones.html'
          },
          'precios': {
            templateUrl: 'app/producto/edit/details/precios.html'
          },
          existencias: {
            templateUrl: 'app/producto/edit/details/existencias.html'
          }
        }
      });
  }
})();
