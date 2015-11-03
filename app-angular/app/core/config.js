// app/core/config.js

(function (){
  'use strict';

  angular
    .module('sagdApp.core')
    .config(configure)
    .run(updateState);

  configure.$inject = ['$urlRouterProvider', '$authProvider', '$locationProvider', 'apiProvider', 'paginationTemplateProvider'];

  function configure($urlRouterProvider, $authProvider, $locationProvider, api, paginationTemplateProvider){
    $authProvider.loginUrl = api.$get().endpoint + '/authenticate';
    $authProvider.withCredentials = true;

    $urlRouterProvider.otherwise('/');

    paginationTemplateProvider.setPath('app/templates/components/pagination-control.html');

    if (window.history && window.history.pushState) {

      $locationProvider.html5Mode(true).hashPrefix('!');

    }
  }

  updateState.$inject = ['$rootScope', '$state', 'state', 'session', 'lscache'];

  function updateState($rootScope, $state, state, session){
    $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams){
      state.setNewState(fromState.name, toState.name);
    });

    lscache.flush();
    session.resetEmpleado();
  }

})();
