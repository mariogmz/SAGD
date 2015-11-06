// app/subfamilia/subfamilia.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .controller('subfamiliaEditController', SubfamiliaEditController);

  SubfamiliaEditController.$inject = ['$stateParams', 'api', 'pnotify'];

  function SubfamiliaEditController($stateParams, api, pnotify){

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarSubfamilia;
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

    function initialize(){
      return obtenerSubfamilia('/subfamilia/', vm.id).then(function (response){
        console.log(response.message);
      });
    }

    function obtenerSubfamilia(){
      return api.get('/subfamilia/', vm.id)
        .then(function (response){
          vm.subfamilia = response.data.subfamilia;
          return response.data;
        })
        .catch(function (response){
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarSubfamilia(){
      return api.put('/subfamilia/', vm.id, vm.subfamilia)
        .then(function (response){
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          return response;
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar la subfamilia', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }
  }

})();
