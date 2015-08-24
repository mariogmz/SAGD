// app/dashboard/LogoutCtrl.js

(function (){

  'use strict';

  angular
    .module('sagdApp')
    .controller('LogoutController', LogoutController);

  LogoutController.$inject = ['$auth', '$state'];

  function LogoutController($auth, $state) {

    if($auth.isAuthenticated()){
      // Logout
    }
    $state.go('login', {});
  }
})();
