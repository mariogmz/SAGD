// app/icecat/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.icecat')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('icecatIndex', {
        url: '',
        parent: 'icecat',
        templateUrl: 'app/icecat/index/index.html',
        controller: 'icecatIndexController',
        controllerAs: 'vm'
      });
  }
})();
