// public/scripts/AuthCtrl.js

(function () {

  'use strict';

  angular
    .module('sagdApp')
    .controller('AuthenticateController', AuthenticateController);

  AuthenticateController.$inject = ['$auth', '$state'];

  function AuthenticateController($auth, $state) {

    if($auth.isAuthenticated()){
      $state.go('home', {});
    }

    var self = this;

    self.login = function () {

      var credentials = {
        email: self.email,
        password: self.password
      };

      // Use Satellizer's $auth service to login
      $auth.login(credentials).then(function (data) {

        // If login is successful, redirect to the users state
        $state.go('home', {});
      });
    };

    self.state = $state.$current.name;

  }

})();
