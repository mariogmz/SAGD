// app/cliente/new/step1/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('clienteNew.step1', {
        parent: 'clienteNew',
        templateUrl: 'app/cliente/new/step1/step1.html'
      });
  }
})();
