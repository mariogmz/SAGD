// app/margen/margen.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenEditController', MargenEditController);

  MargenEditController.$inject = ['$state', '$stateParams', 'api', 'pnotify'];

  function MargenEditController($state, $stateParams, api, pnotify) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarMargen;
    vm.back = goBack;

    vm.fields = [
      {
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
        type: 'input',
        key: 'valor',
        templateOptions: {
          type: 'number',
          label: 'Valor ( % ):',
          placeholder: 'Porcentaje [0 - 100]',
          required: true,
          min: 0,
          max: 100
        }
      }, {
        type: 'input',
        key: 'valor_webservice_p1',
        templateOptions: {
          type: 'number',
          label: 'Webservice P1 ( % ):',
          placeholder: 'Porcentaje [0 - 100]',
          required: true,
          min: 0,
          max: 100
        }
      }, {
        type: 'input',
        key: 'valor_webservice_p8',
        templateOptions: {
          type: 'number',
          label: 'Webservice P8 ( % ):',
          placeholder: 'Porcentaje [0 - 100]',
          required: true,
          min: 0,
          max: 100
        }
      }
    ];

    initialize();

    function initialize() {
      return obtenerMargen('/margen/', vm.id).then(function(response) {
        console.log(response.message);
      });
    }

    function obtenerMargen() {
      return api.get('/margen/', vm.id)
        .then(function(response) {
          vm.margen = response.data.margen;
          angular.merge(vm.margen, {
            valor: vm.margen.valor * 100,
            valor_webservice_p1: vm.margen.valor_webservice_p1 * 100,
            valor_webservice_p8: vm.margen.valor_webservice_p8 * 100
          });
          return response.data;
        })
        .catch(function(response) {
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarMargen() {
      angular.merge(vm.margen, {
        valor: vm.margen.valor / 100,
        valor_webservice_p1: vm.margen.valor_webservice_p1 / 100,
        valor_webservice_p8: vm.margen.valor_webservice_p8 / 100
      });
      return api.put('/margen/', vm.id, vm.margen)
        .then(function(response) {
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          $state.go('margenIndex');
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar el margen', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }
  }

})();
