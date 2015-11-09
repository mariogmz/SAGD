// app/familia/familia.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.familia')
    .controller('familiaNewController', FamiliaNewController);

  FamiliaNewController.$inject = ['$state', 'api', 'pnotify'];

  function FamiliaNewController($state, api, pnotify){

    var vm = this;
    vm.back = goBack;
    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          placeholder: 'Máximo 5 caracteres alfanuméricos',
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
          placeholder: 'Máximo 45 caracteres',
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
      }];

    vm.create = create;

    function create(){
      api.post('/familia', vm.familia)
        .then(function (response){
          pnotify.alert('¡Exito!', response.data.message, 'success');
          $state.go('familiaShow', {id: response.data.familia.id});
        })
        .catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function goBack(){
      window.history.back();
    }
  }

})();
