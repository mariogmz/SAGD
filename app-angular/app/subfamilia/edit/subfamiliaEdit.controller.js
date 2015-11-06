// app/subfamilia/subfamilia.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .controller('subfamiliaEditController', SubfamiliaEditController);

  SubfamiliaEditController.$inject = ['$auth', '$state', '$stateParams', 'api', 'pnotify'];

  function SubfamiliaEditController($auth, $state, $stateParams, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarSubfamilia;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          required: true,
          placeholder: 'Máximo 4 caracteres alfanuméricos',
          maxlength: 4
        },
        validators: {
          validKey: {
            expression: function ($formValue, $modelValue, scope){
              return /^[\w]+$/.test($formValue || $modelValue);
            },
            message: '$viewValue + " contiene caracteres inválidos"'
          }
        }
      }, {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          placeholder: 'Máximo 45 caracteres',
          required: true,
          maxlength: 45
        }
      }, {
        type: 'select',
        key: 'familia_id',
        templateOptions: {
          label: 'Familia:',
          required: true,
          options: [],
          ngOptions: 'familia.id as familia.nombre for familia in to.options | orderBy:"nombre"'
        }
      }, {
        type: 'select',
        key: 'margen_id',
        templateOptions: {
          label: 'Margen:',
          options: [],
          ngOptions: 'margen.id as margen.nombre for margen in to.options | orderBy:"nombre"'
        }
      }
    ];

    initialize();

    function initialize(){
      return obtenerSubfamilia('/subfamilia/', vm.id).then(function (response){
        console.log(response.message);
      });
    }

    function obtenerSubfamilia(){
      return api.get('/subfamilia/', vm.id)
        .then(function (response){
          vm.subfamilia = response.data.subfamilia;
          return response.data;
        })
        .catch(function (response){
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarSubfamilia(){
      return api.put('/subfamilia/', vm.id, vm.subfamilia)
        .then(function (response){
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          return response;
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar la subfamilia', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }
  }

})();
