// app/rol/edit/edit.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .controller('rolEditController', rolEditController);

  rolEditController.$inject = ['$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function rolEditController($stateParams, api, pnotify) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarRol;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          required: true
        }
      }, {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          required: true
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerRol('/rol/', vm.id)
        .then(function(response) {
          console.log(response.message);
        })
    }

    function obtenerRol() {
      return api.get('/rol/', vm.id)
        .then(function(response) {
          vm.rol = response.data.rol;
          return response.data;
        })
        .catch(function(response) {
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarRol() {
      return api.put('/rol/', vm.id, vm.rol)
        .then(function(response) {
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('No se pudo guardar el rol', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }
  }
})();
