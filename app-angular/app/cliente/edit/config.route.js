// app/cliente/edit/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.cliente')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
        .state('clienteEdit', {
          url: 'cliente/editar/:id',
          parent: 'layout',
          templateUrl: 'app/cliente/edit/edit.html',
          controller: 'clienteEditController',
          controllerAs: 'vm'
        });

  }
})();
