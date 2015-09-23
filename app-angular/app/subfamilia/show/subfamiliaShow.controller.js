// app/subfamilia/show/subfamilia.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .controller('subfamiliaShowController', SubfamiliaShowController);

  SubfamiliaShowController.$inject = ['$auth', '$state', '$stateParams', 'api'];

  function SubfamiliaShowController($auth, $state, $stateParams, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
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

    function initialize(){
      return obtenerSubfamilia().then(function (response){
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
  }

})
();
