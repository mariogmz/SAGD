// app/producto/edit/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.producto')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('revisarPreciosEdit', {
        url: '',
        parent: 'revisarPrecios',
        templateUrl: 'app/producto/edit/edit.html'
      });
  }
})();
