// app/unidad/show/unidad.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.unidad')
    .controller('unidadShowController', unidadShowController);

  unidadShowController.$inject = ['$stateParams', 'api'];

  /* @ngInject */
  function unidadShowController($stateParams, api) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave'
        }
      }, {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre'
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerUnidad().then(function(response){
        console.log(response.message);
      });
    }

    function obtenerUnidad() {
      return api.get('/unidad/', vm.id)
        .then(function(response) {
          vm.unidad = response.data.unidad;
          return response.data;
        })
        .catch(function(response){
          vm.error = response.data;
          return response.data;
        });
    }

    function goBack() {
      window.history.back();
    }
  }
})();
