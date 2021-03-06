// app/sucursal/show/sucursalShow.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .controller('sucursalShowController', sucursalShowController);

  sucursalShowController.$inject = ['$stateParams', 'api'];

  /* @ngInject */
  function sucursalShowController($stateParams, api) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:'
        }
      },
      {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:'
        }
      },
      {
        type: 'input',
        key: 'horarios',
        templateOptions: {
          type: 'text',
          label: 'Horario:'
        }
      },
      {
        type: 'input',
        key: 'ubicacion',
        templateOptions: {
          type: 'text',
          label: 'Ubicacion:'
        }
      },
      {
        type: 'input',
        key: 'proveedor.razon_social',
        templateOptions: {
          type: 'text',
          label: 'Proveedor:'
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerSucursal()
        .then(function(response) {
          console.log(response.message);
        });
    }

    function obtenerSucursal() {
      return api.get('/sucursal/', vm.id)
        .then(function(response) {
          vm.sucursal = response.data.sucursal;
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
