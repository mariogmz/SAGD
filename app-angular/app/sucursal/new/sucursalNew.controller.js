// app/sucursal/new/sucursalNew.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .controller('sucursalNewController', sucursalNewController);

  sucursalNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  /* @ngInject */
  function sucursalNewController($auth, $state, api, pnotify) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.back = goBack;
    vm.create = crearSucursal;
    vm.proveedores = [];

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          required: true,
          placeholder: 'Máximo 8 caracteres. 4 de proveedor y 4 de ciudad'
        }
      },
      {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          required: true,
          placeholder: 'Nombre completo de la sucursal'
        }
      },
      {
        type: 'input',
        key: 'horarios',
        templateOptions: {
          type: 'text',
          label: 'Horario:',
          required: true,
          placeholder: 'Especificar que días y a que horas se encuentra abierta esta sucursal'
        }
      },
      {
        type: 'input',
        key: 'ubicacion',
        templateOptions: {
          type: 'text',
          label: 'Ubicacion:',
          placeholder: 'URL a Google Maps con la ubicación de la sucursal/bodega'
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
          assignFields();
        });
    }

    function crearSucursal() {
      return api.post('/sucursal', vm.sucursal)
        .then(function (response){
          pnotify.alert('Exito', response.data.message, 'success');
          $state.go('sucursalShow', {id: response.data.sucursal.id});
        })
        .catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
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
            label: 'Clave:',
            required: true,
            placeholder: 'Máximo 8 caracteres. 4 de proveedor y 4 de ciudad'
          }
        },
        {
          type: 'input',
          key: 'nombre',
          templateOptions: {
            type: 'text',
            label: 'Nombre:',
            required: true,
            placeholder: 'Nombre completo de la sucursal'
          }
        },
        {
          type: 'input',
          key: 'horarios',
          templateOptions: {
            type: 'text',
            label: 'Horario:',
            required: true,
            placeholder: 'Especificar que días y a que horas se encuentra abierta esta sucursal'
          }
        },
        {
          type: 'input',
          key: 'ubicacion',
          templateOptions: {
            type: 'text',
            label: 'Ubicacion:',
            placeholder: 'URL a Google Maps con la ubicación de la sucursal/bodega'
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
