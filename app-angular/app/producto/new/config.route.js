// app/producto/new/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.producto')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('productoNew', {
        url : 'producto/nuevo',
        parent: 'producto',
        templateUrl: 'app/producto/new/new.html',
        controller: 'productoNewController',
        controllerAs: 'parentVm'
      });
  }
})();
