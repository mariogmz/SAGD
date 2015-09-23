// app/garantia/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.garantia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('garantia', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/garantia/garantia.html'
      });
  }
})();

