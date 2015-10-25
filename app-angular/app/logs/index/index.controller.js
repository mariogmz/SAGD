// app/logs/index/index.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.logs')
    .controller('logsIndexController', logsIndexController);

  logsIndexController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function logsIndexController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;

    initialize();

    function initialize(){

    }
  }

})();
