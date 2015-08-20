// app.js

(function () {

  'use strict';

  angular
    .module('sagdApp',['ui.router','satellizer'])
    .config(function($stateProvider, $urlRouterProvider, $authProvider) {

      var baseUrl = 'http://api.sagd.app/api/v1/';
      // Satellizer configuration that specifies which API
      // route the JWT should be retrieved from
      $authProvider.loginUrl = baseUrl + 'authenticate';
      $authProvider.withCredentials = true;

      // Redirect to the auth state if any other states
      // are requested other than users
      $urlRouterProvider.otherwise('/login');

      $stateProvider
        .state('login', {
          url: '/login',
          templateUrl: 'app/authentication/loginView.html',
          controller: 'AuthenticateController as auth'
        })
        .state('empleado', {
          url: '/empleado',
          templateUrl: 'app/empleados/empleadoView.html',
          controller: 'EmpleadoController as empleado'
        });
    });

})();
