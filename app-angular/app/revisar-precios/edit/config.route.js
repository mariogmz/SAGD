// app/revisar-precios/edit/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.revisarPrecios')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('revisarPreciosEdit', {
        url: '',
        parent: 'revisarPrecios',
        templateUrl: 'app/revisar-precios/edit/edit.html'
      });
  }
})();
