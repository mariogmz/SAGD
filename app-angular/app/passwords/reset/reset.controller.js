// app/passwords/reset.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.passwords')
    .controller('passwordsResetController', passwordsResetController);

  passwordsResetController.$inject = ['$auth', '$state', 'api', 'session'];

  /* @ngInject */
  function passwordsResetController($auth, $state, api, session) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.empleado = session.obtenerEmpleado();


    activate();

    ////////////////

    function activate() {
      sendEmail();
    }

    function sendEmail() {
      return api.post('/password/email', {'email': vm.empleado.user.email});
    }
  }
})();
