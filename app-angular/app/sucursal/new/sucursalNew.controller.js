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
    vm.create = crearModelos;
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
      }
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerProveedores()
        .then(function (response) {
          console.log("Proveedores obtenidos");
          assignFields();
        });
    }

    function crearModelos() {
      obtenerCodigoPostal()
      .then(function(response) {
        vm.domicilio.codigo_postal_id = response.data.codigo_postal.id;
        crearDomicilio()
        .then(function(response) {
          vm.sucursal.domicilio_id = response.data.domicilio.id;
          crearSucursal()
          .then(function (response){
            pnotify.alert('Exito', response.data.message, 'success');
            $state.go('sucursalShow', {id: response.data.sucursal.id});
          })
          .catch(createError);
        })
        .catch(createError);
      })
      .catch(findError);
    }

    function findError(response) {
      vm.error = response.data;
      pnotify.alert('No se pudo encontrar el codigo postal', vm.error.error, 'error');
      return response;
    }

    function createError(response) {
      pnotify.alertList(response.data.message, response.data.error, 'error');
    }

    function crearSucursal() {
      return api.post('/sucursal', vm.sucursal);
    }

    function crearDomicilio() {
      return api.post('/domicilio', vm.domicilio);
    }

    function obtenerCodigoPostal() {
      return api.get('/codigo-postal/find/', vm.domicilio.codigo_postal.codigo_postal);
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
        }
      ];
    }
  }
})();
