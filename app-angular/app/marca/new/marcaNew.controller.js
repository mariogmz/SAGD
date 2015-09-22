// app/marca/marca.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.marca')
    .controller('marcaNewController', MarcaNewController);

  MarcaNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function MarcaNewController($auth, $state, api, pnotify){
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
          placeholder: 'Máximo 3 caracteres alfanuméricos',
          required: true
        }
      }, {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          placeholder: 'Máximo 25 caracteres',
          required: true
        }
      }];

    vm.create = create;

    function create(){
      api.post('/marca', vm.marca)
        .then(function (response){
          debugger;
          pnotify.alert('¡Exito!', response.data.message, 'success');
          $state.go('marcaShow', {id: response.data.marca.id});
        })
        .catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }
  }

})();
