// app/cliente/clienteNew.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteNewController', ClienteNewController);

  ClienteNewController.$inject = ['$state', 'api', 'pnotify', 'Cliente'];

  function ClienteNewController($state, api, pnotify, Cliente) {

    var vm = this;

    vm.onSubmit = onSubmit;
    vm.previous = goToStep1;
    vm.next = goToStep2;

    activate();

    function activate() {
      vm.fieldsStepOne = [
        {
          type: 'input',
          key: 'nombre',
          templateOptions: {
            type: 'text',
            label: 'Nombre:',
            placeholder: 'Introduzca el nombre',
            required: true
          }
        }, {
          type: 'input',
          key: 'fecha_nacimiento',
          templateOptions: {
            type: 'date',
            label: 'Fecha de nacimiento:',
            placeholder: 'Fecha de nacimiento'
          }
        }, {
          type: 'select',
          key: 'sexo',
          templateOptions: {
            label: 'Sexo:',
            options: [
              {value: 'HOMBRE', name: 'Hombre'},
              {value: 'MUJER', name: 'Mujer'}
            ],
            required: true
          }
        }, {
          type: 'input',
          key: 'ocupacion',
          templateOptions: {
            type: 'text',
            label: 'Ocupación:'
          }
        }, {
          type: 'input',
          key: 'fecha_verificacion_correo',
          templateOptions: {
            type: 'date',
            label: 'Fecha en que verificó correo:',
            placeholder: 'Fecha de verificación de correo',
            disabled: true
          }
        }, {
          type: 'input',
          key: 'fecha_expira_club_zegucom',
          templateOptions: {
            type: 'date',
            label: 'Fecha de expiración de club zegucom:',
            placeholder: 'Fecha expiración club zegucom'
          }
        }
      ];
      vm.fieldsUser = [
        {
          type: 'input',
          key: 'usuario',
          templateOptions: {
            type: 'text',
            label: 'Usuario:',
            placeholder: 'Nombre de usuario',
          }
        }, {
          type: 'input',
          key: 'email',
          templateOptions: {
            type: 'email',
            label: 'Correo electrónico:',
            placeholder: 'usuario@hotmail.com',
          }
        }
      ];
      vm.fieldsStepTwo = [
        {
          type: 'select',
          key: 'cliente_estatus_id',
          templateOptions: {
            label: 'Estatus:',
            required: true,
            options: [],
            ngOptions: 'clientes_estatus.id as clientes_estatus.nombre for clientes_estatus in to.options | orderBy:"nombre"'
          }
        }, {
          type: 'select',
          key: 'rol_id',
          templateOptions: {
            label: 'Rol:',
            options: [],
            ngOptions: 'roles.id as roles.nombre for roles in to.options | orderBy:"nombre"',
            required: true
          }
        }, {
          type: 'select',
          key: 'sucursal_id',
          templateOptions: {
            label: 'Sucursal de preferencia:',
            required: true,
            options: [],
            ngOptions: 'sucursales.id as sucursales.nombre for sucursales in to.options | orderBy:"id"'
          }
        }, {
          type: 'select',
          key: 'cliente_referencia_id',
          templateOptions: {
            label: 'Referencia:',
            options: [],
            ngOptions: 'clientes_referencias.id as clientes_referencias.nombre for clientes_referencias in to.options | orderBy:"nombre"'
          }
        }, {
          type: 'input',
          key: 'tabulador',
          templateOptions: {
            type: 'number',
            label: 'Tabulador original:',
            required: true,
            min: 1,
            max: 10
          }
        }
      ];

      var empleado = JSON.parse(localStorage.getItem('empleado'));
      vm.model = {
        fecha_verificacion_correo: new Date(),
        empleado_id: empleado.id,
        vendedor_id: empleado.id,
        tabulador: 1,
        domicilio: {}
      };
      vm.telephone = true;
      $state.go('clienteNew.step1');

      obtenerReferencias()
        .then(obtenerRoles)
        .then(obtenerEstatus)
        .then(obtenerSucursales)
        .then(assignFields);
    }

    function onSubmit() {
      return Cliente.create(vm.model)
        .then(function(cliente) {
          $state.go('clienteShow', {id: cliente.id});
          return cliente;
        })
        .catch(function(error) {
          console.error(error);
        });
    }

    function goToStep1() {
      $state.go('clienteNew.step1');
    }

    function goToStep2() {
      $state.go('clienteNew.step2');
    }

    function obtenerReferencias() {
      return api.get('/cliente-referencia')
        .then(function(response) {
          vm.referencias = response.data;
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('Hubo un problema al obtener las Referencias', vm.error.error, 'error');
          return response;
        });
    }

    function obtenerRoles() {
      return api.get('/roles/clientes')
        .then(function(response) {
          vm.roles = response.data;
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('Hubo un problema al obtener los Roles', vm.error.message, 'error');
          return response;
        });
    }

    function obtenerEstatus() {
      return api.get('/cliente-estatus')
        .then(function(response) {
          vm.estatus = response.data;
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('Hubo un problema al obtener los Estatus', vm.error.error, 'error');
          return response;
        });
    }

    function obtenerSucursales() {
      return api.get('/sucursal')
        .then(function(response) {
          vm.sucursales = response.data.filter(function(sucursal) {
            return !sucursal.proveedor.externo;
          });

          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('Hubo un problema al obtener las Sucursales', vm.error.error, 'error');
          return response;
        });
    }

    function assignFields() {
      vm.fieldsStepTwo = vm.fieldsStepTwo.map(function(object) {
        if (object.key == 'cliente_referencia_id') {
          object.templateOptions.options = vm.referencias;
        }

        if (object.key == 'rol_id') {
          object.templateOptions.options = vm.roles;
        }

        if (object.key == 'cliente_estatus_id') {
          object.templateOptions.options = vm.estatus;
        }

        if (object.key == 'sucursal_id') {
          object.templateOptions.options = vm.sucursales;
        }

        return object;
      });
    }

  }

})();
