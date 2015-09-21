// app/proveedor/new/onfig.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.proveedor')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
        .state('proveedorNew', {
          url: 'sucursales/proveedor/nuevo',
          parent: 'layout',
          templateUrl: 'app/proveedor/new/new.html',
          controller: 'proveedorNewController',
          controllerAs: 'vm'
        });

  }
})();
