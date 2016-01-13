// app/passwords/email.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.passwords')
    .controller('passwordsEmailController', passwordsEmailController);

  passwordsEmailController.$inject = ['api', 'session', 'pnotify'];

  /* @ngInject */
  function passwordsEmailController(api, session, pnotify) {

    var vm = this;
    vm.disabled = false;
    vm.sendEmail = sendEmail;
    vm.empleado = session.obtenerEmpleado();

    activate();

    ////////////////

    function activate() {
    }

    function sendEmail() {
      if (vm.disabled) {
        return;
      }
      ;
      postEmailToEndpoint()
        .then(function() {
          vm.disabled = true;
          pnotify.alert('¡Exito!', "Su link para cambiar su contraseña llegará momentaneamente", 'success');
        })
        .catch(function() {
          vm.disabled = true;
          pnotify.alert('Error', 'Hubo un error al enviar el correo, intente más tarde', 'error');
        });
    }

    function postEmailToEndpoint() {
      return api.post('/password/email', {'email': vm.empleado.user.email});
    }
  }
})();
