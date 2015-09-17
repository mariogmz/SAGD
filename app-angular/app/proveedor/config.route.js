// app/proveedor/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.proveedor')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('proveedor', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/proveedor/proveedor.html'
      });
  }
})();
