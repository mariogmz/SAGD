// app/rol/new.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .controller('rolNewController', rolNewController);

  rolNewController.$inject = ['$state', 'api', 'pnotify'];

  /* @ngInject */
  function rolNewController($state, api, pnotify) {

    var vm = this;

    vm.create = create;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          placeholder: 'Máximo 20 caracteres',
          required: true
        }
      }, {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          placeholder: 'Máximo 45 caracteres',
          required: true
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
    }

    function create() {
      api.post('/rol', vm.rol)
        .then(function(response){
          pnotify.alert('Exito', response.data.message, 'success');
          $state.go('rolShow', {id: response.data.rol.id});
        })
        .catch(function(response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function goBack() {
      window.history.back();
    }
  }
})();
