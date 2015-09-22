// app/proveedor/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.proveedor')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
        .state('proveedor', {
          url: 'sucursales/proveedor',
          parent: 'layout',
          templateUrl: 'app/proveedor/proveedor.html',
          controller: 'proveedorIndexController',
          controllerAs: 'vm'
        });
  }
})();
