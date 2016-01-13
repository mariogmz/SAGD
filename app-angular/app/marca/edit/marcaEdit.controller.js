// app/marca/marca.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.marca')
    .controller('marcaEditController', MarcaEditController);

  MarcaEditController.$inject = ['$state', '$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function MarcaEditController($state, $stateParams, api, pnotify) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarMarca;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          required: true
        }
      }, {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          required: true
        }
      }
    ];

    initialize();

    function initialize() {
      return obtenerMarca('/marca/', vm.id).then(function(response) {
        console.log(response.message);
      });
    }

    function obtenerMarca() {
      return api.get('/marca/', vm.id)
        .then(function(response) {
          vm.marca = response.data.marca;
          return response.data;
        })
        .catch(function(response) {
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarMarca() {
      return api.put('/marca/', vm.id, vm.marca)
        .then(function(response) {
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          $state.go('marcaIndex');
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar la marca', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }
  }

})();
