// app/transferencia/index/tabs/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.transferencia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('transferenciaIndex.tabs', {
        parent: 'transferenciaIndex',
        views: {
          salidas: {
            templateUrl: 'app/transferencia/index/tabs/salidas.template.html'
          },
          entradas: {
            templateUrl: 'app/transferencia/index/tabs/entradas.template.html'
          }
        }
      });
  }
})();
