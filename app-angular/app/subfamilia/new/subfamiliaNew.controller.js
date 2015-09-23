// app/subfamilia/subfamilia.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .controller('subfamiliaNewController', SubfamiliaNewController);

  SubfamiliaNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function SubfamiliaNewController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          placeholder: 'Máximo 5 caracteres alfanuméricos',
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
      }, {
        type: 'textarea',
        key: 'descripcion',
        templateOptions: {
          label: 'Descripción:',
          placeholder: 'Máximo 100 caracteres'
        }
      }];

    vm.create = create;

    function create(){
      api.post('/subfamilia', vm.subfamilia)
        .then(function (response){
          debugger;
          pnotify.alert('¡Exito!', response.data.message, 'success');
          $state.go('subfamiliaShow', {id: response.data.subfamilia.id});
        })
        .catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }
  }

})();
