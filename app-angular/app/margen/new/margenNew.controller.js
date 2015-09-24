// app/margen/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenNewController', MargenNewController);

  MargenNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function MargenNewController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;

    vm.back = goBack;
    vm.fields = [
      {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          placeholder: 'Máximo 45 caracteres',
          required: true
        }
      }, {
        type: 'input',
        key: 'valor',
        templateOptions: {
          type: 'text',
          label: 'Valor:',
          placeholder: 'Porcentaje. [0.00 - 1.00]',
          required: true
        }
      }, {
        type: 'input',
        key: 'valor_webservice_p1',
        templateOptions: {
          type: 'text',
          label: 'Webservice P1:',
          placeholder: 'Porcentaje. [0.00 - 1.00]',
          required: true
        }
      }, {
        type: 'input',
        key: 'valor_webservice_p8',
        templateOptions: {
          type: 'text',
          label: 'Webservice P8:',
          placeholder: 'Porcentaje. [0.00 - 1.00]',
          required: true
        }
      }
    ];

    vm.create = create;

    function create(){
      api.post('/margen', vm.margen)
        .then(function (response){
          debugger;
          pnotify.alert('¡Exito!', response.data.message, 'success');
          $state.go('margenShow', {id: response.data.margen.id});
        })
        .catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function goBack() {
      window.history.back();
    }
  }

})();
