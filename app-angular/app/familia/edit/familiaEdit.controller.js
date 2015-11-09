// app/familia/familia.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.familia')
    .controller('familiaEditController', FamiliaEditController);

  FamiliaEditController.$inject = ['$stateParams', 'api', 'pnotify'];

  function FamiliaEditController($stateParams, api, pnotify){

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarFamilia;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          required: true,
          maxlength: 5
        },
        validators: {
          validKey: {
            expression: function ($viewValue, $modelValue, scope){
              return /^[\w]+$/.test($viewValue || $modelValue);
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
          required: true,
          maxlength: 45
        }
      }, {
        type: 'textarea',
        key: 'descripcion',
        templateOptions: {
          label: 'Descripción:',
          placeholder: 'Máximo 100 caracteres',
          maxlength: 100
        }
      }
    ];

    initialize();

    function initialize(){
      return obtenerFamilia('/familia/', vm.id).then(function (response){
        console.log(response.message);
      });
    }

    function obtenerFamilia(){
      return api.get('/familia/', vm.id)
        .then(function (response){
          vm.familia = response.data.familia;
          return response.data;
        })
        .catch(function (response){
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarFamilia(){
      return api.put('/familia/', vm.id, vm.familia)
        .then(function (response){
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          return response;
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar la familia', vm.error.error, 'error');
          return response;
        });
    }

    function goBack(){
      window.history.back();
    }
  }

})();
