// app/cliente/new/step2/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('clienteNew.step2', {
        parent: 'clienteNew',
        templateUrl: 'app/cliente/new/step2/step2.html'
      });
  }
})();
