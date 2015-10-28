// app/empleado/show/show.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.empleado')
    .controller('empleadoShowController', empleadoShowController);

  empleadoShowController.$inject = ['$auth', '$state', '$stateParams', 'api'];

  /* @ngInject */
  function empleadoShowController($auth, $state, $stateParams, api) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

    vm.fields = [
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
        key: 'usuario',
        templateOptions: {
          type: 'text',
          label: 'Usuario:'
        }
      },
      {
        type: 'input',
        key: 'puesto',
        templateOptions: {
          type: 'text',
          label: 'Puesto:'
        }
      },
      {
        type: 'input',
        key: 'sucursal.nombre',
        templateOptions: {
          type: 'input',
          label: 'Sucursal:'
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
          ]
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerEmpleado().then(function (response) {
          console.log(response.message);
        });
    }

    function obtenerEmpleado() {
      return api.get('/empleado/', vm.id).then(function (response) {
        vm.empleado = response.data.empleado;
        return response.data;
      })
      .catch(function (response) {
        vm.error = response.data;
        return response.data;
      });
    }

    function goBack() {
      window.history.back();
    }
  }
})();
