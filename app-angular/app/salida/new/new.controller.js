// app/salida/new/new.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .controller('salidaNewController', salidaNewController);

  salidaNewController.$inject = ['$state', 'api', 'pnotify'];

  /* @ngInject */
  function salidaNewController($state, api, pnotify) {

    var vm = this;

    vm.create = create;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'motivo',
        templateOptions: {
          type: 'text',
          label: 'Motivo:',
          placeholder: '¿Porqué se realiza esta salida?',
          required: true,
          maxlength: 140
        },
      }, {
        type: 'input',
        key: 'fecha_salida',
        defaultValue: new Date(),
        templateOptions: {
          type: 'date',
          label: 'Fecha:',
          maxlength: 45
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
    }

    function create() {
      api.post('/salida', vm.salida)
        .then(function(response) {
          pnotify.alert('Exito', response.data.message, 'success');
          $state.go('salidaShow', {id: response.data.salida.id});
        })
        .catch(function(response) {
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function goBack() {
      window.history.back();
    }
  }
})();
