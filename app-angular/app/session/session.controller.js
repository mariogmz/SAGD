// app/session/session.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.session')
    .controller('SessionController', SessionController);

  SessionController.$inject = ['session'];

  function SessionController(session){
    var vm = this;

    vm.login = login;
    vm.logout = logout;
    vm.clean = cleanLoginError;


    function login(){
      vm.loading = true;
      session.login(vm.email, vm.password).then(function (){
        vm.loginError = session.getLoginError();
        vm.loading = false;
      });
    }

    function logout(){
      session.logout();
    }

    function cleanLoginError(evt){
      session.cleanLoginError();
      vm.loginError = session.getLoginError();
    }

  }

})();
