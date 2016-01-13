// app/pretransferencia/index/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.pretransferencia')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('pretransferenciaIndex', {
        url: 'pretransferencias',
        parent: 'pretransferencia',
        templateUrl: 'app/pretransferencia/index/index.html',
        controller: 'pretransferenciaIndexController',
        controllerAs: 'vm'
      });
  }
})();
