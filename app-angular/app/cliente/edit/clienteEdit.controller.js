// app/cliente/clienteEdit.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteEditController', ClienteEditController);

  ClienteEditController.$inject = ['$auth', '$state', '$stateParams', '$location', 'api', 'pnotify'];

  function ClienteEditController($auth, $state, $stateParams, $location, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;

    vm.id = $stateParams.id;
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

    function obtenerCliente(){
      return api.get('/cliente/', vm.id)
          .then(function (response){
            vm.cliente = response.data.cliente;
            return response.data;
          })
          .catch(function (response){
            vm.error = response.data;
            return response.data;
          });
    }

    vm.cliente = obtenerCliente(vm.id);

    function onSubmit(){

      return api.put('/cliente/', vm.cliente.id, vm.cliente)
      .then(function (response){
            vm.message = response.data.message;
            pnotify.alert('Exito', vm.message, 'success');
            $state.go('clienteShow', {id: vm.cliente.id});

          })
          .catch(function (response){
            vm.error = response.data;
            pnotify.alertList('No se pudo modificar el cliente', vm.error.error, 'error');
            return response;
         });
    }

  }

})();
