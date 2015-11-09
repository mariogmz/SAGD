// app/empleado/edit/edit.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.empleado')
    .controller('empleadoEditController', empleadoEditController);

  empleadoEditController.$inject = ['$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function empleadoEditController($stateParams, api, pnotify) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarEmpleado;
    vm.back = goBack;
    vm.sucursales = {};
    vm.fields = [
      {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          required: true
        }
      },
      {
        type: 'input',
        key: 'usuario',
        templateOptions: {
          type: 'text',
          label: 'Usuario:',
          required: true
        }
      },
      {
        type: 'input',
        key: 'puesto',
        templateOptions: {
          type: 'text',
          label: 'Puesto:',
          required: true
        }
      },
      {
        type: 'select',
        key: 'sucursal_id',
        templateOptions: {
          type: 'select',
          label: 'Sucursal:',
          options: [{ value: 0, name: 'Seleccione a que sucursal pertenecerá'}],
          ngOptions: 'sucursal.id as sucursal.nombre group by sucursal.proveedor.razon_social for sucursal in to.options | orderBy:"nombre"',
          required: true
        }
      },
      {
        type: 'select',
        key: 'activo',
        templateOptions: {
          type: 'select',
          label: 'Activo:',
          options: [
            {value: 0, name: 'No activar'},
            {value: 1, name: 'Activar'},
          ],
          required: true
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerSucursales().then(function (response) {
          console.log("Sucursales obtenidas");
          obtenerEmpleado().then(function (response) {
            console.log(response.message);
            assignFields();
          });
        });
    }

    function obtenerEmpleado() {
      return api.get('/empleado/', vm.id)
        .then(function (response) {
          vm.empleado = response.data.empleado;
          return response.data;
        })
        .catch(function (response) {
          vm.error = response.data;
          return response.data;
        });
    }

    function updateError(response) {
      vm.error = response.data;
      pnotify.alert('No se pudo guardar la empleado', vm.error.message, 'error');
      return response;
    }

    function guardarEmpleado() {
      return api.put('/empleado/', vm.id, vm.empleado)
      .then(function(response){
        vm.message = response.data.message;
        pnotify.alert('Exito', vm.message, 'success');
      })
      .catch(updateError);
    }

    function obtenerSucursales() {
      return api.get('/sucursal')
        .then(function (response) {
          vm.sucursales = response.data;
          return response;
        })
        .catch(function (response) {
          vm.error = response.data;
          pnotify.alert('No se pudo obtener las sucursales', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }

    function assignFields() {
      vm.fields = vm.fields.map(function(object) {
        if(object.key == "sucursal_id") {
          object.templateOptions.options = vm.sucursales;
        }
        return object;
      });
    }
  }
})();
