// app/revisar-precios/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.revisarPrecios')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('revisarPrecios', {
        url: 'revisar-precios',
        parent: 'layout',
        templateUrl: 'app/revisar-precios/revisar-precios.html',
        controller: 'revisarPreciosController',
        controllerAs: 'vm'
      });
  }
})();
