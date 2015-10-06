// app/cliente/clienteNew.controller.js

(function (){

  'use strict';

  angular
      .module('sagdApp.cliente')
      .controller('clienteNewController', ClienteNewController);

  ClienteNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function ClienteNewController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;

    vm.onSubmit = onSubmit;
    vm.model = {};

    vm.fields = [
      {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          label: 'Nombre:',
          placeholder: 'Introduzca el nombre',
          required: true
        }
      }, {
        type: 'input',
        key: 'usuario',
        templateOptions: {
          label: 'Usuario:',
          placeholder: 'Introduzca el usuario',
          required: true
        }
      }, {
        type: 'select',
        key: 'sexo',
        templateOptions: {
          label: 'Sexo:',
          options: [
            {value: "HOMBRE", name: "Hombre"},
            {value: "MUJER", name: "Mujer"}
          ]
        }
      }, {
        type: 'select',
        key: 'cliente_referencia_id',
        templateOptions: {
          label: 'Referencia:',
          options: [],
          ngOptions: 'clientes_referencias.id as clientes_referencias.nombre for clientes_referencias in to.options | orderBy:"nombre"',
          required: true,
        }

      }, {
        type: 'select',
        key: 'rol_id',
        templateOptions: {
          label: 'Rol:',
          options: [],
          ngOptions: 'roles.id as roles.nombre for roles in to.options | orderBy:"nombre"',
          required: true,
        }
      }, {
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
        key: 'sucursal_id',
        templateOptions: {
          label: 'Sucursal de preferencia:',
          required: true,
          options: [],
          ngOptions: 'sucursales.id as sucursales.nombre for sucursales in to.options | orderBy:"id"'
        }
      }

    ];


    activate();

    function activate() {

      return obtenerReferencias()
        .then(function (response) {
          return obtenerRoles()
            .then(function (response) {
              return obtenerEstatus()
                .then(function (response) {
                  return obtenerSucursales()
                    .then(function (response) {
                      assignFields();
                    });
                });
            });
        });
    }


    function onSubmit(){
      return api.post('/cliente', vm.model)
          .then(function (response){
            vm.message = response.data.message;
            pnotify.alert('Exito', vm.message, 'success');
            $state.go('clienteShow', {id: response.data.cliente.id});
          })
          .catch(function (response){
            vm.error = response.data;
            pnotify.alertList('No se pudo guardar el cliente', vm.error.error, 'error');
            return response;
          });
    }

    function obtenerReferencias() {
      return api.get('/cliente-referencia')
          .then(function (response) {
            vm.referencias = response.data;
            return response;
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener las Referencias', vm.error.error, 'error');
            return response;
          });
    }

    function obtenerRoles() {
      return api.get('/rol')
          .then(function (response) {
            vm.roles = response.data;
            return response;
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener los Roles', vm.error.error, 'error');
            return response;
          });
    }

    function obtenerEstatus() {
      return api.get('/cliente-estatus')
          .then(function (response) {
            vm.estatus = response.data;
            return response;
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener los Estatus', vm.error.error, 'error');
            return response;
          });
    }

    function obtenerSucursales() {
      return api.get('/sucursal')
          .then(function (response) {
            vm.sucursales = response.data;
            return response;
          })
          .catch(function (response) {
            vm.error = response.data;
            pnotify.alert('Hubo un problema al obtener las Sucursales', vm.error.error, 'error');
            return response;
          });
    }

    function assignFields() {
      vm.fields = vm.fields.map(function(object) {
        if(object.key == "cliente_referencia_id") {
          object.templateOptions.options = vm.referencias;
        }

        if(object.key == "rol_id") {
          object.templateOptions.options = vm.roles;
        }

        if(object.key == "cliente_estatus_id") {
          object.templateOptions.options = vm.estatus;
        }

        if(object.key == "sucursal_id") {
          object.templateOptions.options = vm.sucursales;
        }

        return object;
      });
    }

  }

})();
