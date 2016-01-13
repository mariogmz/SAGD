// app/session/session.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.session')
    .controller('SessionController', SessionController);

  SessionController.$inject = ['session', 'api', 'pnotify'];

  /* @ngInject */
  function SessionController(session, api, pnotify) {
    var vm = this;

    vm.forgotPassword = false;
    vm.login = login;
    vm.logout = logout;
    vm.clean = cleanLoginError;
    vm.sendPasswordResetLink = sendLink;

    function login() {
      vm.loading = true;
      session.login(vm.email, vm.password).then(function() {
        vm.loginError = session.getLoginError();
        vm.loading = false;
      });
    }

    function logout() {
      session.logout();
    }

    function cleanLoginError(evt) {
      session.cleanLoginError();
      vm.loginError = session.getLoginError();
    }

    function sendLink() {
      postEmailToEndpoint().then(function() {
          pnotify.alert('Correo enviado', 'En un momento recibirá instrucciones para reestablecer su contraseña', 'success');
        })
        .catch(function() {
          pnotify.alert('Correo no enviado', 'Hubo un error, intente más tarde', 'error');
        });
    }

    function postEmailToEndpoint() {
      return api.post('/password/email', {'email': vm.passwordResetEmail});
    }

  }

})();
