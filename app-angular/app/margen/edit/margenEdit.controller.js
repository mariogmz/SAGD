// app/margen/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenEditController', MargenEditController);

  MargenEditController.$inject = ['$auth', '$state', '$stateParams', 'api'];

  function MargenEditController($auth, $state, $stateParams, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarMargen;
    vm.clean = limpiar;

    vm.fields = [
      {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          required: true,
          onChange: limpiar
        }
      }, {
        type: 'input',
        key: 'valor',
        templateOptions: {
          type: 'text',
          label: 'Valor:',
          required: true,
          onChange: limpiar
        }
      }, {
        type: 'input',
        key: 'valor_webservice_p1',
        templateOptions: {
          type: 'text',
          label: 'Webservice P1:',
          required: true,
          onChange: limpiar
        }
      }, {
        type: 'input',
        key: 'valor_webservice_p8',
        templateOptions: {
          type: 'text',
          label: 'Webservice P8:',
          required: true,
          onChange: limpiar
        }
      }
    ];

    initialize();

    function initialize(){
      return obtenerMargen('/margen/', vm.id).then(function (response){
        console.log(response.message);
      });
    }

    function obtenerMargen(){
      return api.get('/margen/', vm.id)
        .then(function (response){
          vm.margen = response.data.margen;
          return response.data;
        })
        .catch(function (response){
          vm.alert.error = response.data;
          return response.data;
        });
    }

    function guardarMargen(){
      return api.put('/margen/', vm.id, vm.margen)
        .then(function (response){
          vm.alert.message = response.data.message;
          vm.alert.error = false;
          return response;
        })
        .catch(function (response){
          vm.alert.error = response.data;
          return response;
        });
    }

    function limpiar(){
      vm.alert.message = null;
      vm.alert.error = null;
    }
  }

})();
