// app/marca/show/marca.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.marca')
    .controller('marcaShowController', MarcaShowController);

  MarcaShowController.$inject = ['$stateParams', 'api'];

  /* @ngInject */
  function MarcaShowController($stateParams, api) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:'
        }
      }, {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:'
        }
      }
    ];
    initialize();

    function initialize() {
      return obtenerMarca().then(function(response) {
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

    function goBack() {
      window.history.back();
    }
  }

})
();
