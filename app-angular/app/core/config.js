// app/core/config.js

(function() {
    'use strict';

    var core = angular.module('sagdApp.core');

    core.config(configure);

    configure.$inject = ['$stateProvider', '$urlRouterProvider', '$authProvider', '$locationProvider'];

    function configure ($stateProvider, $urlRouterProvider, $authProvider, $locationProvider) {
      var baseUrl = 'http://api.sagd.app/api/v1';
      $authProvider.loginUrl = baseUrl + '/authenticate';
      $authProvider.withCredentials = true;

      $urlRouterProvider.otherwise('/login');

      if (window.history && window.history.pushState) {
        $locationProvider.html5Mode(true).hashPrefix('!');
      }
    }

    core.run(['$state', angular.noop]);
})();
