// app/marca/show/marca.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.marca')
    .controller('marcaShowController', MarcaShowController);

  MarcaShowController.$inject = ['$auth', '$state', '$stateParams', 'api'];

  function MarcaShowController($auth, $state, $stateParams, api){
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
      }
    ];
    initialize();

    function initialize(){
      return obtenerMarca().then(function (response){
        console.log(response.message);
      });
    }

    function obtenerMarca(){
      return api.get('/marca/', vm.id)
        .then(function (response){
          vm.marca = response.data.marca;
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
