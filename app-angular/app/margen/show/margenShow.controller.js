// app/margen/show/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenShowController', MargenShowController);

  MargenShowController.$inject = ['$auth', '$state', '$stateParams', 'api'];

  function MargenShowController($auth, $state, $stateParams, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.fields = [
      {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          required: true
        }
      }, {
        type: 'input',
        key: 'valor',
        templateOptions: {
          type: 'text',
          label: 'Valor:',
          required: true
        }
      }, {
        type: 'input',
        key: 'valor_webservice_p8',
        templateOptions: {
          type: 'text',
          label: 'Webservice P8:',
          required: true
        }
      }, {
        type: 'input',
        key: 'valor_webservice_p1',
        templateOptions: {
          type: 'text',
          label: 'Webservice P1:',
          required: true
        }
      }
    ]
    ;
    initialize();

    function initialize(){
      return obtenerMargen().then(function (response){
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
          vm.error = response.data;
          return response.data;
        });
    }
  }

})
();
