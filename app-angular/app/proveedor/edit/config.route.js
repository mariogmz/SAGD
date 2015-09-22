// app/proveedor/edit/onfig.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.proveedor')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
        .state('proveedorEdit', {
          url: 'sucursales/proveedor/editar/:id',
          parent: 'layout',
          templateUrl: 'app/proveedor/edit/edit.html',
          controller: 'proveedorEditController',
          controllerAs: 'vm'
        });

  }
})();
