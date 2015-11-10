// app/empleado/new/new.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.empleado')
    .controller('empleadoNewController', empleadoNewController);

  empleadoNewController.$inject = ['$state', 'api', 'pnotify'];

  /* @ngInject */
  function empleadoNewController($state, api, pnotify) {

    var vm = this;
    vm.back = goBack;
    vm.create = crearEmpleado;
    vm.sucursal = {};

    vm.fields = [
      {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          required: true,
          placeholder: 'Nombre del nuevo empleado'
        }
      },
      {
        type: 'input',
        key: 'usuario',
        templateOptions: {
          type: 'text',
          label: 'Usuario:',
          required: true,
          placeholder: 'Usuario que tendra el nuevo empleado'
        }
      },
      {
        type: 'input',
        key: 'puesto',
        templateOptions: {
          type: 'text',
          label: 'Puesto:',
          required: true,
          placeholder: 'Indique que puesto tiene el nuevo empleado'
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
      obtenerSucursales().then(function(response) {
        assignFields();
      });
    }

    function crearEmpleado() {
      return api.post('/empleado', vm.empleado)
      .then(function(response){
        pnotify.alert('Exito', response.data.message, 'success');
        $state.go('empleadoShow', {id: response.data.sucursal.id});
      })
      .catch(function(response){
        vm.error = response.data;
        pnotify.alert('No se pudo crear el empleado', vm.error.error, 'error');
      });
    }

    function obtenerSucursales() {
      return api.get('/sucursal', [{'key': 'base', 'value': 'true'}]).then(function(response) {
        vm.sucursales = response.data;
        return response;
      }).catch(function(response){
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
