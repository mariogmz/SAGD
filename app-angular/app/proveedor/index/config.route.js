// app/proveedor/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.proveedor')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
        .state('proveedorIndex', {
          url: 'sucursales/proveedor',
          parent: 'layout',
          templateUrl: 'app/proveedor/index/index.html',
          controller: 'proveedorController',
          controllerAs: 'vm'
        });
  }
})();
