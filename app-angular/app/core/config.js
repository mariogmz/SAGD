// app/core/config.js

(function (){
  'use strict';

  angular
    .module('sagdApp.core')
    .config(configure)
    .run(updateState);

  configure.$inject = ['$urlRouterProvider', '$authProvider', '$locationProvider','paginationTemplateProvider'];

  function configure($urlRouterProvider, $authProvider, $locationProvider, paginationTemplateProvider){
    var baseUrl = "http://api.sagd.app/api/v1";
    $authProvider.loginUrl = baseUrl + '/authenticate';
    $authProvider.withCredentials = true;

    $urlRouterProvider.otherwise('/');

    paginationTemplateProvider.setPath('app/templates/components/pagination-control.html');

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
