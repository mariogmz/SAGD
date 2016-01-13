// app/passwords/email/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.passwords')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  /* @ngInject */
  function configureRoutes($stateProvider) {
    $stateProvider
      .state('passwordsEmail', {
        url: 'password/email',
        parent: 'passwords',
        templateUrl: 'app/passwords/email/email.html',
        controller: 'passwordsEmailController',
        controllerAs: 'vm'
      });
  }
})();
