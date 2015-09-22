// app/familia/config.route.js

(function (){
  'use strict';

  angular
    .module('sagdApp.familia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider){
    $stateProvider
      .state('familia', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/familia/familia.html'
      });
  }
})();
