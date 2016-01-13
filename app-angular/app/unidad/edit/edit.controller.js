// app/unidad/edit/edit.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.unidad')
    .controller('unidadEditController', unidadEditController);

  unidadEditController.$inject = ['$state', '$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function unidadEditController($state, $stateParams, api, pnotify) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarUnidad;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
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
          required: true,
          maxlength: 45
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerUnidad('/unidad/', vm.id)
        .then(function(response) {
          console.log(response.message);
        })
    }

    function obtenerUnidad() {
      return api.get('/unidad/', vm.id)
        .then(function(response) {
          vm.unidad = response.data.unidad;
          return response.data;
        })
        .catch(function(response) {
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarUnidad() {
      return api.put('/unidad/', vm.id, vm.unidad)
        .then(function(response) {
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          $state.go('unidadIndex');
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alert('No se pudo guardar la marca', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }
  }
})();
