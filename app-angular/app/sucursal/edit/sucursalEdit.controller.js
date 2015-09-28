// app/sucursal/edit/sucursalEdit.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .controller('sucursalEditController', sucursalEditController);

  sucursalEditController.$inject = ['$auth', '$state', '$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function sucursalEditController($auth, $state, $stateParams, api, pnotify) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarSucursal;
    vm.back = goBack;
    vm.sucursal = [];
    vm.proveedores = [];
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
          type: 'select',
          key: 'proveedor_id',
          templateOptions: {
            type: 'select',
            label: 'Proveedor:',
            options: [{value: 0, name: 'Seleccione un proveedor'}],
            required: true
          }
        },
        {
          type: 'input',
          key: 'domicilio_id',
          templateOptions: {
            type: 'text',
            label: 'Domicilio:'
          }
        }
      ];

    activate();

    ////////////////

    function activate() {
      return obtenerProveedores()
        .then(function (response) {
          console.log(response.message);
          obtenerSucursal()
            .then(function (response) {
              console.log(response.message);
              assignFields();
            })
        });
    }

    function obtenerSucursal() {
      return api.get('/sucursal/', vm.id)
        .then(function (response) {
          vm.sucursal = response.data.sucursal;
          return response.data;
        })
        .catch(function (response) {
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarSucursal() {
      return api.put('/sucursal/', vm.id, vm.sucursal)
        .then(function (response) {
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          return response;
        })
        .catch(function (response) {
          vm.error = response.data;
          pnotify.alert('No se pudo guardar la sucursal', vm.error.error, 'error');
          return response;
        });
    }

    function obtenerProveedores() {
      return api.get('/proveedor')
        .then(function (response) {
          vm.proveedores = response.data;
          return response;
        })
        .catch(function (response) {
          vm.error = response.data;
          pnotify.alert('No se pudo obtener los proveedores', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }

    function assignFields() {
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
          type: 'select',
          key: 'proveedor_id',
          templateOptions: {
            type: 'select',
            label: 'Proveedor:',
            options: vm.proveedores.map(function(proveedor) {
              return {value: proveedor.id, name: proveedor.razon_social};
            }),
            required: true
          }
        },
        {
          type: 'input',
          key: 'domicilio_id',
          templateOptions: {
            type: 'text',
            label: 'Domicilio:'
          }
        }
      ];
    }
  }
})();
