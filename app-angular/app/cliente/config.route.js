// app/cliente/config.route.js

(function (){
  'use strict';

  angular
      .module('sagdApp.cliente')
      .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider){
    $stateProvider
        .state('cliente', {
          abstract: true,
          url: '',
          parent: 'layout',
          templateUrl: 'app/cliente/cliente.html'
        });
  }
})();
