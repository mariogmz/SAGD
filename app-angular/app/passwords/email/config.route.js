// app/passwords/email/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.passwords')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('passwordsEmail', {
        url: 'passwords/email',
        parent: 'passwords',
        templateUrl: 'app/passwords/email/email.html',
        controller: 'passwordsEmailController',
        controllerAs: 'vm'
      });
  }
})();
