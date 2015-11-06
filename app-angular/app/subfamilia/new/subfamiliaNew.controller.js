// app/subfamilia/subfamilia.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .controller('subfamiliaNewController', SubfamiliaNewController);

  SubfamiliaNewController.$inject = ['$state', 'api', 'pnotify'];

  function SubfamiliaNewController($state, api, pnotify){

    var vm = this;
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
          placeholder: 'Seleccione un margen',
          options: [],
          ngOptions: 'margen.id as margen.nombre for margen in to.options | orderBy:"nombre"'
        }
      }
    ];

    vm.create = create;

    activate();

    function activate(){
      obtenerFamilias().then(function (response){
        obtenerMargenes().then(function (response){
          assignFields();
        })
      })
    }

    function create(){
      api.post('/subfamilia', vm.subfamilia)
        .then(function (response){
          pnotify.alert('¡Exito!', response.data.message, 'success');
          $state.go('subfamiliaShow', {id: response.data.subfamilia.id});
        })
        .catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function obtenerFamilias(){
      return api.get('/familia')
        .then(function (response){
          vm.familias = response.data;
          return response;
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alert('No se pudo obtener las familias', vm.error.error, 'error');
          return response;
        });
    }

    function obtenerMargenes(){
      return api.get('/margen')
        .then(function (response){
          vm.margenes = response.data;
          return response;
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alert('No se pudo obtener los margenes', vm.error.error, 'error');
          return response;
        });
    }

    function goBack(){
      window.history.back();
    }

    function assignFields(){
      vm.fields = vm.fields.map(function (field){
        if (field.key == "familia_id") {
          field.templateOptions.options = vm.familias;
        }
        if (field.key == "margen_id") {
          field.templateOptions.options = vm.margenes;
        }
        return field;
      });
    }
  }

})();
