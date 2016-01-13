// app/acl/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.acl')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('unauthorized', {
        abstract: false,
        url: 'unauthorized',
        parent: 'layout',
        templateUrl: 'app/templates/components/unauthorized.html'
      });
  }
})();
