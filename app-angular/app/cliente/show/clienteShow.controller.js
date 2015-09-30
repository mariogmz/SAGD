// app/cliente/show/cliente.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteShowController', ClienteShowController);

  ClienteShowController.$inject = ['$auth', '$state', '$stateParams', 'api'];

  function ClienteShowController($auth, $state, $stateParams, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

    vm.fields = [
      {
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
    initialize();

    function initialize(){
      return obtenerClientes().then(function (response){
        console.log(response.message);
      });
    }

    function obtenerClientes(){
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

    function goBack() {
      window.history.back();
    }
  }

})
();
