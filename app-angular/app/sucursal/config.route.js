// app/sucursal/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('sucursal', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/sucursal/sucursal.html'
      });
  }
})();
