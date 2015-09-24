// app/garantia/garantia.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.garantia')
    .controller('garantiaNewController', garantiaNewController);

  garantiaNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  /* @ngInject */
  function garantiaNewController($auth, $state, api, pnotify) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.create = create;
    vm.garantia = {
      dias: 0,
      seriado: 1
    };
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'descripcion',
        templateOptions: {
          type: 'text',
          label: 'Descripcion:',
          placeholder: 'Máximo 45 caracteres',
          required: true
        }
      }, {
        type: 'input',
        key: 'dias',
        templateOptions: {
          type: 'number',
          label: 'Días:',
          min: 0
        }
      }, {
        type: 'select',
        key: 'seriado',
        templateOptions: {
          type: 'select',
          label: 'Seriado:',
          options: [
            {value: 0, name: 'No'},
            {value: 1, name: 'Si'}
          ],
          required: true
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
    }

    function create() {
      api.post('/tipo-garantia', vm.garantia)
        .then(function(response){
          pnotify.alert('Exito', response.data.message, 'success');
          $state.go('garantiaShow', {id: response.data.tipoGarantia.id});
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
