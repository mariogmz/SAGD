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
          label: 'Usuario',
          placeholder: 'Introduzca el usuario',
          required: true
        }
      }, {
        type: 'select',
        key: 'sexo',
        templateOptions: {
          label: 'Sexo',
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
      }

    ];

    function onSubmit(){
      return api.post('/cliente', vm.model)
          .then(function (response){
            vm.message = response.data.message;
            pnotify.alert('Exito', vm.message, 'success');
            $state.go('clienteShow', {id: response.data.proveedor.id});
          })
          .catch(function (response){
            vm.error = response.data;
            pnotify.alertList('No se pudo guardar el cliente', vm.error.error, 'error');
            return response;
          });
    }

  }

})();
