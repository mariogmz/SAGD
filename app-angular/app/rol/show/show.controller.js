// app/rol/show/rol.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .controller('rolShowController', rolShowController);

  rolShowController.$inject = ['$stateParams', 'api'];

  /* @ngInject */
  function rolShowController($stateParams, api) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave'
        }
      }, {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre'
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerRol().then(function(response) {
        console.log(response.message);
      });
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

    function goBack() {
      window.history.back();
    }
  }
})();
