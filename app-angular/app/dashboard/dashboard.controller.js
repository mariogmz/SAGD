// app/dashboard/dashboard.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.dashboard')
    .controller('DashboardController', DashboardController);

  DashboardController.$inject = ['$auth', '$state'];

  function DashboardController($auth, $state) {
    if(! $auth.isAuthenticated()){
      $state.go('login', {});
    }
  }
})();
