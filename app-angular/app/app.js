// app.js

(function () {

  'use strict';

  angular
    .module('sagdApp', ['ui.router', 'satellizer'])
    .config(['$stateProvider', '$urlRouterProvider', '$authProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $authProvider, $locationProvider) {

      var baseUrl = 'http://api.sagd.app/api/v1/';
      // Satellizer configuration that specifies which API
      // route the JWT should be retrieved from
      $authProvider.loginUrl = baseUrl + 'authenticate';
      $authProvider.withCredentials = true;

      $urlRouterProvider.otherwise('/login');

      $stateProvider
        .state('home', {
          url: '/',
          templateUrl: 'app/dashboard/dashboardView.html',
          controller: 'DashboardController as dash'
        })
        .state('login', {
          url: '/login',
          templateUrl: 'app/authentication/loginView.html',
          controller: 'AuthenticateController as auth'
        })
        .state('logout', {
          url: '/logout',
          templateUrl: 'app/logout/logoutView.html',
          controller: 'LogoutController as logout'
        })
        .state('empleado', {
          url: '/empleado',
          templateUrl: 'app/empleado/empleadoView.html',
          controller: 'EmpleadoController as empleado'
        });

      if (window.history && window.history.pushState) {
        $locationProvider.html5Mode(true).hashPrefix('!');
      }
    }])
    .run(['$state', angular.noop]);

})();
