// app/cliente/clienteNew.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteNewController', ClienteNewController);

  ClienteNewController.$inject = ['$auth', '$state', '$stateParams', '$location', 'api', 'pnotify'];

  function ClienteNewController($auth, $state, $stateParams, $location, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;

    vm.onSubmit = onSubmit;
    vm.model = {};

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          label: 'Clave:',
          placeholder: 'Introduzca la clave',
          required: true
        },
        validators: {
          notEquals: '$viewValue != "admin"'
        }
      },{
        type: 'input',
        key: 'usuario',
        templateOptions: {
          label: 'Usuario',
          placeholder: 'Introduzca el usuario',
          required: true
        }
      },{
        type: 'input',
        key: 'nombre',
        templateOptions: {
          label: 'Nombre',
        }
      },{
        type: 'select',
        key: 'activo',
        templateOptions: {
          label: '¿Activo?',
          options:
            [
              { value: 0, name: "No" },
              { value: 1, name: "Si" }
            ]
        }
      }

    ];

    function onSubmit(){

      return api.post('/cliente', vm.model)
      .then(function (response){
            vm.message = response.data.message;
            pnotify.alert('Exito', vm.message, 'success');
            $state.go('clienteShow', {id: response.data.cliente.id});
          })
          .catch(function (response){
            vm.error = response.data;
            pnotify.alertList('No se pudo guardar el cliente', vm.error.error, 'error');
            return response;
         });
    }

  }

})();
