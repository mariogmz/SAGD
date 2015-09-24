// app/proveedor/new/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.proveedor')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('proveedorNew', {
        url: 'proveedor/nuevo',
        parent: 'layout',
        templateUrl: 'app/proveedor/new/new.html',
        controller: 'proveedorNewController',
        controllerAs: 'vm'
      });

  }
})();
