// app/cliente/show/cliente.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteShowController', ClienteShowController);

  ClienteShowController.$inject = ['$auth', '$state', '$stateParams', 'api'];

  function ClienteShowController($auth, $state, $stateParams, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

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
    initialize();

    function initialize(){
      return obtenerCliente().then(function (response){
        console.log(response.message);
        $state.go('clienteShow.details');
      });
    }

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

    function goBack() {
      window.history.back();
    }
  }

})
();
