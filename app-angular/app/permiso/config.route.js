// app/permiso/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.permiso')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('permiso', {
        abstract: true,
        url: '',
        parent: 'layout',
        templateUrl: 'app/permiso/permiso.html'
      });
  }
})();
