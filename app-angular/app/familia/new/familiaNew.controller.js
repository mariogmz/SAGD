// app/familia/familia.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.familia')
    .controller('familiaNewController', FamiliaNewController);

  FamiliaNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function FamiliaNewController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.back = goBack;
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
      api.post('/familia', vm.familia)
        .then(function (response){
          pnotify.alert('¡Exito!', response.data.message, 'success');
          $state.go('familiaShow', {id: response.data.familia.id});
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
