// app/core/config.js

(function (){
  'use strict';

  angular
    .module('sagdApp.core')
    .config(configure)
    .run(updateState);

  configure.$inject = ['$urlRouterProvider', '$authProvider', '$locationProvider', 'apiProvider'];

  function configure($urlRouterProvider, $authProvider, $locationProvider, api){
    $authProvider.loginUrl = api.$get().endpoint + '/authenticate';
    $authProvider.withCredentials = true;

    $urlRouterProvider.otherwise('/');

    if (window.history && window.history.pushState) {
      $locationProvider.html5Mode(true).hashPrefix('!');
    }
  }

  updateState.$inject = ['$rootScope', '$state', 'state'];

  function updateState($rootScope, $state, state){
    $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams){
      state.setNewState(fromState.name, toState.name);
    });
  }

})();
