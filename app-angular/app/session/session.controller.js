// app/session/session.controller.js

(function () {

  'use strict';

  angular
    .module('sagdApp.session')
    .controller('SessionController', SessionController);

  SessionController.$inject = ['session'];

  function SessionController(session) {
    var vm = this;

    vm.login = function () {
      session.login(vm.email, vm.password).then(function(){
        vm.loginError = session.getLoginError();
      });
    };

    vm.logout = function () {
      session.logout();
    };

    vm.cleanLoginError = function(evt){
      session.cleanLoginError();
      vm.loginError = session.getLoginError();
    };

  }

})();
