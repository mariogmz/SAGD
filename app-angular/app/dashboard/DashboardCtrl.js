// app/dashboard/DashboardCtrl.js

(function (){

  'use strict';

  angular
    .module('sagdApp')
    .controller('DashboardController', DashboardController);

  DashboardController.$inject = ['$auth', '$state'];

  function DashboardController($auth, $state) {

    if(! $auth.isAuthenticated()){
      $state.go('login', {});
    }
  }
})();
