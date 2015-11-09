// app/garantia/edit/edit.controller.js

(function (){
  'use strict';

  angular
    .module('sagdApp.garantia')
    .controller('garantiaEditController', garantiaEditController);

  garantiaEditController.$inject = ['$state', '$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function garantiaEditController($state, $stateParams, api, pnotify) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarGarantia;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'descripcion',
        templateOptions: {
          type: 'text',
          label: 'Descripcion:',
          placeholder: 'Máximo 45 caracteres',
          required: true,
          maxlength: 45
        }
      }, {
        type: 'input',
        key: 'dias',
        templateOptions: {
          type: 'number',
          label: 'Días:',
          min: 0
        }
      }, {
        type: 'select',
        key: 'seriado',
        templateOptions: {
          type: 'select',
          label: 'Seriado:',
          required: true,
          options: [
            {value: 0, name: 'No'},
            {value: 1, name: 'Si'}
          ]
        }
      }
    ];

    activate();

    ////////////////

    function activate(){
      return obtenerGarantia()
        .then(function (response){
          console.log(response.message);
        });
    }

    function obtenerGarantia(){
      return api.get('/tipo-garantia/', vm.id)
        .then(function (response){
          vm.garantia = response.data.tipoGarantia;
          return response.data;
        })
        .catch(function (response){
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarGarantia(){
      return api.put('/tipo-garantia/', vm.id, vm.garantia)
        .then(function (response){
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          $state.go('tipoGarantiaIndex');
          return response;
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar la marca', vm.error.error, 'error');
          return response;
        });
    }

    function goBack(){
      window.history.back();
    }
  }
})();
