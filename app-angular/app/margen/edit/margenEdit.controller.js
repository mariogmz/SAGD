// app/margen/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenEditController', MargenEditController);

  MargenEditController.$inject = ['$auth', '$state', '$stateParams', 'api', 'pnotify'];

  function MargenEditController($auth, $state, $stateParams, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarMargen;

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
        key: 'valor_webservice_p1',
        templateOptions: {
          type: 'text',
          label: 'Webservice P1:',
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
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarMargen(){
      return api.put('/margen/', vm.id, vm.margen)
        .then(function (response){
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          return response;
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar el margen', vm.error.error, 'error');
          return response;
        });
    }
  }

})();
