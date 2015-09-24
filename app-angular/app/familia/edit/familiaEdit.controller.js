// app/familia/familia.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.familia')
    .controller('familiaEditController', FamiliaEditController);

  FamiliaEditController.$inject = ['$auth', '$state', '$stateParams', 'api', 'pnotify'];

  function FamiliaEditController($auth, $state, $stateParams, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarFamilia;
    vm.back = goBack;

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

    initialize();

    function initialize(){
      return obtenerFamilia('/familia/', vm.id).then(function (response){
        console.log(response.message);
      });
    }

    function obtenerFamilia(){
      return api.get('/familia/', vm.id)
        .then(function (response){
          vm.familia = response.data.familia;
          return response.data;
        })
        .catch(function (response){
          vm.error = response.data;
          return response.data;
        });
    }

    function guardarFamilia(){
      return api.put('/familia/', vm.id, vm.familia)
        .then(function (response){
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          return response;
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar la familia', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }
  }

})();
