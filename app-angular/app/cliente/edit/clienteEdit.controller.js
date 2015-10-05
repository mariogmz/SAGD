// app/cliente/clienteEdit.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteEditController', ClienteEditController);

  ClienteEditController.$inject = ['$auth', '$state', '$stateParams', '$location', 'api', 'pnotify'];

  function ClienteEditController($auth, $state, $stateParams, $location, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;

    vm.id = $stateParams.id;
    vm.onSubmit = onSubmit;
    vm.model = {};

    vm.fields = [
      {
        type: 'input',
        key: 'usuario',
        templateOptions: {
          label: 'Usuario',
          placeholder: 'Introduzca el usuario',
          required: true
        }
      },{
        type: 'input',
        key: 'nombre',
        templateOptions: {
          label: 'Nombre',
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
          required: true,
          options: [],
          ngOptions: 'clientes_referencias.id as clientes_referencias.nombre for clientes_referencias in to.options'
        },
        controller: /* @ngInject */ function ($scope){
          $scope.to.loading = api.get('/cliente-referencia').then(function (response){
            $scope.to.options = response.data;
            return response;
          });
        }
      }, {
        type: 'select',
        key: 'rol_id',
        templateOptions: {
          label: 'Rol:',
          required: true,
          options: [],
          ngOptions: 'roles.id as roles.nombre for roles in to.options'
        },
        controller: /* @ngInject */ function ($scope){
          $scope.to.loading = api.get('/rol').then(function (response){
            $scope.to.options = response.data;
            return response;
          });
        }
      }, {
        type: 'select',
        key: 'cliente_estatus_id',
        templateOptions: {
          label: 'Estatus:',
          required: true,
          options: [],
          ngOptions: 'clientes_estatus.id as clientes_estatus.nombre for clientes_estatus in to.options'
        },
        controller: /* @ngInject */ function ($scope){
          $scope.to.loading = api.get('/cliente-estatus').then(function (response){
            $scope.to.options = response.data;
            return response;
          });
        }
      }, {
        type: 'select',
        key: 'sucursal_id',
        templateOptions: {
          label: 'Sucursal de preferencia:',
          required: true,
          options: [],
          ngOptions: 'sucursales.id as sucursales.nombre for sucursales in to.options'
        },
        controller: /* @ngInject */ function ($scope){
          $scope.to.loading = api.get('/sucursal').then(function (response){
            $scope.to.options = response.data;
            return response;
          });
        }
      }

    ];

    function obtenerCliente(){
      return api.get('/cliente/', vm.id)
          .then(function (response){
            vm.cliente = response.data.cliente;
            return response.data;
          })
          .catch(function (response){
            vm.error = response.data;
            return response.data;
          });
    }

    vm.cliente = obtenerCliente();

    function onSubmit(){

      return api.put('/cliente/', vm.cliente.id, vm.cliente)
      .then(function (response){
            vm.message = response.data.message;
            pnotify.alert('Exito', vm.message, 'success');
            $state.go('clienteShow', {id: vm.cliente.id});

          })
          .catch(function (response){
            vm.error = response.data;
            pnotify.alertList('No se pudo modificar el cliente', vm.error.error, 'error');
            return response;
         });
    }

  }

})();
