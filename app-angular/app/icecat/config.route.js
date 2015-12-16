// app/icecat/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.icecat')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('icecat', {
        abstract: true,
        url: 'icecat',
        parent: 'layout',
        templateUrl: 'app/icecat/icecat.html'
      });
  }
})();
