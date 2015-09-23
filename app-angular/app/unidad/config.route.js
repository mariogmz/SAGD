// app/unidad/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.unidad')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('unidad', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/unidad/unidad.html'
      });
  }
})();
