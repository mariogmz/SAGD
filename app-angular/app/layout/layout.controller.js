// app/home/home.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.layout')
    .controller('layoutController', LayoutController);

  LayoutController.$inject = ['$auth', '$state'];

  /* @ngInject */
  function LayoutController($auth, $state) {
    var vm = this;
    vm.isAuthenticated = $auth.isAuthenticated;
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }
  }
})();
