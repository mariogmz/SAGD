// app/icecat/features/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.icecat')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('icecatFeatures', {
        url: '/caracteristicas',
        parent: 'icecat',
        templateUrl: 'app/icecat/features/features.html',
        controller: 'icecatFeaturesController',
        controllerAs: 'vm'
      });
  }
})();
