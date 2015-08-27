// app/session/session.controller.js

(function () {

  'use strict';

  angular
    .module('sagdApp.session')
    .controller('SessionController', SessionController);

  SessionController.$inject = ['$auth', '$state'];

  function SessionController($auth, $state) {
    var vm = this;
    var auth = $auth;
    var state = $state;

    var redirectToHomeIfAuthenticated = function () {
      if(auth.isAuthenticated()){
        state.go('home', {});
      }
    }

    var logoutUserIfAuthenticated = function () {
      if($auth.isAuthenticated()){
        $auth.removeToken();
      }
    }

    vm.login = function () {
      redirectToHomeIfAuthenticated();
      var credentials = {
        email: vm.email,
        password: vm.password
      };

      $auth.login(credentials).then(function (data) {
        $state.go('home', {});
      });
    };

    vm.logout = function () {
      logoutUserIfAuthenticated();
      state.go('login', {});
    }
  }

})();
