// app/icecat/features/show/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.icecat')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('icecatFeaturesShow', {
        url: '/caracteristicas/:id',
        parent: 'icecat',
        templateUrl: 'app/icecat/features/show/show.html',
        controller: 'icecatFeaturesShowController',
        controllerAs: 'vm'
      });
  }
})();
