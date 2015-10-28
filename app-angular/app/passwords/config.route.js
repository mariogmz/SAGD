// app/passwords/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.passwords')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('passwords', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/passwords/passwords.html'
      });
  }
})();
