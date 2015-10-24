// app/session/session.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.session')
    .controller('SessionController', SessionController);

  SessionController.$inject = ['session', 'api'];

  function SessionController(session, api){
    var vm = this;

    vm.forgotPassword = false;
    vm.login = login;
    vm.logout = logout;
    vm.clean = cleanLoginError;
    vm.sendPasswordResetLink = sendLink;

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

    function sendLink() {
      postEmailToEndpoint();
    }

    function postEmailToEndpoint() {
      return api.post('/password/email', {'email': vm.passwordResetEmail});
    }

  }

})();
