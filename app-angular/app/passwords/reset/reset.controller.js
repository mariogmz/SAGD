// app/passwords/reset/reset.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.passwords')
    .controller('passwordsResetController', passwordsResetController);

  passwordsResetController.$inject = ['$auth', '$state', '$stateParams', 'api', 'session', 'pnotify'];

  /* @ngInject */
  function passwordsResetController($auth, $state, $stateParams, api, session, pnotify) {

    var vm = this;
    vm.token = $stateParams.token;
    vm.empleado = session.obtenerEmpleado();
    vm.model = {
      token: vm.token,
      email: vm.empleado.user.email
    };
    vm.fields = [
      {
        type: 'hidden',
        key: 'token'
      },
      {
        type: 'hidden',
        key: 'email'
      },
      {
        type: 'input',
        key: 'password',
        templateOptions: {
          type: 'password',
          label: 'Contraseña',
          required: true
        }
      },
      {
        type: 'input',
        key: 'password_confirmation',
        templateOptions: {
          type: 'password',
          label: 'Confirmar contraseña',
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
