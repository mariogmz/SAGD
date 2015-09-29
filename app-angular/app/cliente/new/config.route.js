// app/cliente/new/onfig.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.cliente')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
        .state('clienteNew', {
          url: 'cliente/nuevo',
          parent: 'cliente',
          templateUrl: 'app/cliente/new/new.html',
          controller: 'clienteNewController',
          controllerAs: 'vm'
        });

  }
})();
