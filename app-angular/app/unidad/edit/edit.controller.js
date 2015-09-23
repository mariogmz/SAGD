// app/unidad/edit/edit.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.unidad')
    .controller('unidadEditController', unidadEditController);

  unidadEditController.$inject = ['$auth', '$state', '$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function unidadEditController($auth, $state, $stateParams, api, pnotify) {
    if(!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarUnidad;

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

    activate();

    ////////////////

    function activate() {
      return obtenerUnidad('/unidad/', vm.id)
        .then(function(response){
          console.log(response.message);
        })
    }

    function obtenerUnidad() {
      return api.get('/unidad/', vm.id)
        .then(function(response){
          vm.unidad = response.data.unidad;
          return response.data;
        })
        .catch(function(response){
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarUnidad() {
      return api.put('/unidad/', vm.id, vm.unidad)
        .then(function (response){
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          return response;
        })
        .catch(function(response){
          vm.error = response.data;
          pnotify.alert('No se pudo guardar la marca', vm.error.error, 'error');
          return response;
        });
    }
  }
})();
