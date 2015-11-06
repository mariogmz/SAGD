// app/margen/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenNewController', MargenNewController);

  MargenNewController.$inject = ['$state', 'api', 'pnotify'];

  function MargenNewController($state, api, pnotify){

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
          required: true,
          maxlength: 45
        }
      }, {
        type: 'input',
        key: 'valor',
        templateOptions: {
          type: 'number',
          label: 'Valor ( % ):',
          placeholder: 'Porcentaje [0 - 100]',
          required: true,
          min: 0,
          max: 100
        }
      }, {
        type: 'input',
        key: 'valor_webservice_p1',
        templateOptions: {
          type: 'number',
          label: 'Webservice P1 ( % ):',
          placeholder: 'Porcentaje [0 - 100]',
          required: true,
          min: 0,
          max: 100
        }
      }, {
        type: 'input',
        key: 'valor_webservice_p8',
        templateOptions: {
          type: 'number',
          label: 'Webservice P8 ( % ):',
          placeholder: 'Porcentaje [0 - 100]',
          required: true,
          min: 0,
          max: 100
        }
      }
    ];

    vm.create = create;

    function create(){
      angular.merge(vm.margen, {
        valor: vm.margen.valor / 100,
        valor_webservice_p1: vm.margen.valor_webservice_p1 / 100,
        valor_webservice_p8: vm.margen.valor_webservice_p8 / 100
      });
      api.post('/margen', vm.margen)
        .then(function (response){
          pnotify.alert('¡Exito!', response.data.message, 'success');
          $state.go('margenShow', {id: response.data.margen.id});
        })
        .catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function goBack(){
      window.history.back();
    }
  }

})();
