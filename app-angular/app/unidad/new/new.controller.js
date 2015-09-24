// app/unidad/unidad.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.unidad')
    .controller('unidadNewController', unidadNewController);

  unidadNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  /* @ngInject */
  function unidadNewController($auth, $state, api, pnotify) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

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
          placeholder: 'Máximo 4 letras',
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
      api.post('/unidad', vm.unidad)
        .then(function(response){
          pnotify.alert('Exito', response.data.message, 'success');
          $state.go('unidadShow', {id: response.data.unidad.id});
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
