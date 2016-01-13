// app/unidad/unidad.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.unidad')
    .controller('unidadNewController', unidadNewController);

  unidadNewController.$inject = ['$state', 'api', 'pnotify'];

  /* @ngInject */
  function unidadNewController($state, api, pnotify) {

    var vm = this;

    vm.create = create;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          placeholder: 'Máximo 4 letras',
          required: true
        },
        validators: {
          validKey: {
            expression: function($viewValue, $modelValue, $scope) {
              return /^[a-zA-Z]{1,4}$/.test($modelValue || $viewValue);
            },
            message: '$viewValue + " no es una clave válida"'
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
      }
    ];

    activate();

    ////////////////

    function activate() {
    }

    function create() {
      api.post('/unidad', vm.unidad)
        .then(function(response) {
          pnotify.alert('Exito', response.data.message, 'success');
          $state.go('unidadShow', {id: response.data.unidad.id});
        })
        .catch(function(response) {
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function goBack() {
      window.history.back();
    }
  }
})();
