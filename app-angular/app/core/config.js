// app/core/config.js

(function() {
  'use strict';

  angular
    .module('sagdApp.core')
    .config(configure)
    .run(updateState);

  configure.$inject = ['$urlRouterProvider', '$urlMatcherFactoryProvider', '$authProvider', '$locationProvider', '$httpProvider', 'apiProvider', 'paginationTemplateProvider'];

  function configure($urlRouterProvider, $urlMatcherFactoryProvider, $authProvider, $locationProvider, $httpProvider, api, paginationTemplateProvider) {
    $httpProvider.interceptors.push('apiObserver');
    $authProvider.loginUrl = api.$get().endpoint + '/authenticate';
    $authProvider.withCredentials = true;

    $urlRouterProvider.otherwise('/');
    $urlMatcherFactoryProvider.strictMode(false);

    paginationTemplateProvider.setPath('app/templates/components/pagination-control.html');

    if (window.history && window.history.pushState) {

      $locationProvider.html5Mode(true).hashPrefix('!');

    }
  }

  updateState.$inject = ['$rootScope', '$state', 'state', 'session', 'lscache'];

  function updateState($rootScope, $state, state, session) {
    $rootScope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams) {
      state.setNewState(fromState.name, toState.name);
    });

    lscache.flush();
    if (session.isAuthenticated()) {
      session.resetEmpleado();
    }
  }

})();
