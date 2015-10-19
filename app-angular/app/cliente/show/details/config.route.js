// app/cliente/show/details/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.cliente')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('clienteShow.details', {
        parent: 'clienteShow',
        views: {
          'datos-generales': {
            templateUrl: 'app/cliente/show/details/datos-generales.html'
          },
          'tabuladores': {
            templateUrl: 'app/cliente/show/details/tabuladores.html'
          },
          'razones-sociales': {
            templateUrl: 'app/cliente/show/details/razones-sociales.html'
          },
          'movimientos': {
            templateUrl: 'app/cliente/show/details/movimientos.html'
          }
        }
      });
  }
})();
