// app/familia/show/familia.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.familia')
    .controller('familiaShowController', FamiliaShowController);

  FamiliaShowController.$inject = ['$stateParams', 'api'];

  /* @ngInject */
  function FamiliaShowController($stateParams, api) {

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
      }, {
        type: 'textarea',
        key: 'descripcion',
        templateOptions: {
          label: 'Descripción'
        }
      }
    ];
    initialize();

    function initialize() {
      return obtenerFamilia().then(function(response) {
        console.log(response.message);
      });
    }

    function obtenerFamilia() {
      return api.get('/familia/', vm.id)
        .then(function(response) {
          vm.familia = response.data.familia;
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
