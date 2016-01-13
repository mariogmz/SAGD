// app/cliente/edit/details/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('clienteEdit.details', {
        parent: 'clienteEdit',
        views: {
          'datos-generales': {
            templateUrl: 'app/cliente/edit/details/datos-generales.html'
          },
          contacto: {
            templateUrl: 'app/cliente/edit/details/contacto.html'
          },
          preferencias: {
            templateUrl: 'app/cliente/edit/details/preferencias.html'
          },
          tabuladores: {
            templateUrl: 'app/cliente/edit/details/tabuladores.html'
          },
          comentarios: {
            templateUrl: 'app/cliente/edit/details/comentarios.html'
          }
        }
      });
  }
})();
