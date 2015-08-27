// app/home/home.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.home')
    .controller('HomeController', HomeController);

  HomeController.$inject = ['$auth', '$state'];

  function HomeController($auth, $state) {
    if(! $auth.isAuthenticated()){
      $state.go('login', {});
    }
  }
})();
