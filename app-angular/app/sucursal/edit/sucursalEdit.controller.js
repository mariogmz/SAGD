// app/sucursal/edit/sucursalEdit.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .controller('sucursalEditController', sucursalEditController);

  sucursalEditController.$inject = ['$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function sucursalEditController($stateParams, api, pnotify) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarModelos;
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
          ngOptions: 'proveedor.id as proveedor.razon_social for proveedor in to.options | orderBy:"razon_social"',
          required: true
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerProveedores()
        .then(function(response) {
          console.log('Proveedores obtenidos');
          obtenerSucursal()
            .then(function(response) {
              console.log(response.message);
              assignFields();
            });
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

    function guardarModelos() {
      obtenerCodigoPostal()
        .then(function(response) {
          vm.sucursal.domicilio.codigo_postal_id = response.data.codigo_postal.id;
          guardarDomicilio()
            .then(function(response) {
              return guardarSucursal()
                .then(function(response) {
                  vm.message = response.data.message;
                  pnotify.alert('Exito', vm.message, 'success');
                  return response;
                })
                .catch(updateError);
            })
            .catch(updateError);
        })
        .catch(updateError);
    }

    function updateError(response) {
      vm.error = response.data;
      pnotify.alert('No se pudo guardar la sucursal', vm.error.message, 'error');
      return response;
    }

    function guardarSucursal() {
      return api.put('/sucursal/', vm.id, vm.sucursal);
    }

    function guardarDomicilio() {
      return api.put('/domicilio/', vm.sucursal.domicilio_id, vm.sucursal.domicilio);
    }

    function obtenerCodigoPostal() {
      return api.get('/codigo-postal/find/', vm.sucursal.domicilio.codigo_postal.codigo_postal);
    }

    function obtenerProveedores() {
      return api.get('/proveedor')
        .then(function(response) {
          vm.proveedores = response.data;
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('No se pudo obtener los proveedores', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }

    function assignFields() {
      vm.fields = vm.fields.map(function(object) {
        if (object.key == 'proveedor_id') {
          object.templateOptions.options = vm.proveedores;
        }

        return object;
      });
    }
  }
})();
