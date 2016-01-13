// app/revisar-precios/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.revisarPrecios')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('revisarPreciosIndex', {
        url: '',
        parent: 'revisarPrecios',
        templateUrl: 'app/revisar-precios/index/index.html'
      });
  }
})();
