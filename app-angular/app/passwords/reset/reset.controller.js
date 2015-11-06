// app/passwords/reset/reset.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.passwords')
    .controller('passwordsResetController', passwordsResetController);

  passwordsResetController.$inject = ['$stateParams', 'api', 'session', 'pnotify'];

  /* @ngInject */
  function passwordsResetController($stateParams, api, session, pnotify) {

    var vm = this;
    vm.token = $stateParams.token;
    vm.empleado = session.obtenerEmpleado();
    vm.email = vm.empleado ? vm.empleado.user.email : null;
    vm.emailRequired = vm.email ? false : true;
    vm.emailPlaceholder = vm.email ? vm.email : 'Ingrese su correo electrónico';

    vm.model = {
      token: vm.token,
      email: vm.email
    };
    vm.fields = [
      {
        type: 'hidden',
        key: 'token'
      },
      {
        type: 'input',
        key: 'email',
        templateOptions: {
          type: 'email',
          label: 'Correo electrónico',
          placeholder: vm.emailPlaceholder,
          required: vm.emailRequired,
          disabled: !vm.emailRequired
        }
      },
      {
        type: 'input',
        key: 'password',
        templateOptions: {
          type: 'password',
          label: 'Contraseña',
          placeholder: 'Ingrese su nueva contraseña. Mímino 8 caracteres',
          required: true
        }
      },
      {
        type: 'input',
        key: 'password_confirmation',
        templateOptions: {
          type: 'password',
          label: 'Confirmar contraseña',
          placeholder: 'Confirmar contraseña',
          required: true
        }
      }
    ];
    vm.onSubmit = sendReset;
    vm.empleado = session.obtenerEmpleado();


    activate();

    ////////////////

    function activate() {
    }

    function sendReset() {
      validateModel().then(function(){
        postResetEndpoint().then(function(response){
          pnotify.alert('¡Exito!', "Tu consaseña ha sido reestablecida", 'success');
          $state.go('home', {});
        })
        .catch(function(response){
          pnotify.alert('Error', "Hubo un error al intentar reestablecer tu contraseña, intente más tarde", 'error');
        });
      })
      .catch(function(){
        pnotify.alert('Error', 'Las contraseñas no coinciden', 'error');
      });
    }

    function validateModel() {
      return new Promise(function(resolve, reject) {
        if ( vm.model.password === vm.model.password_confirmation ) {
          resolve();
        } else {
          reject();
        }
      });
    }

    function postResetEndpoint() {
      return api.post('/password/reset', vm.model);
    }
  }
})();
