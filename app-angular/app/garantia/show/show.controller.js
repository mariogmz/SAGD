// app/garantia/show/show.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.garantia')
    .controller('garantiaShowController', garantiaShowController);

  garantiaShowController.$inject = ['$auth', '$state', '$stateParams', 'api'];

  /* @ngInject */
  function garantiaShowController($auth, $state, $stateParams, api) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.fields = [
      {
        type: 'input',
        key: 'descripcion',
        templateOptions: {
          type: 'text',
          label: 'Descripcion:'
        }
      }, {
        type: 'input',
        key: 'dias',
        templateOptions: {
          type: 'number',
          label: 'Días:'
        }
      }, {
        type: 'input',
        key: 'seriado',
        templateOptions: {
          type: 'text',
          label: 'Seriado:'
        }
      }
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerGarantia().then(function(response){
        console.log(response.message);
      })
    }

    function obtenerGarantia() {
      return api.get('/tipo-garantia/', vm.id)
        .then(function(response) {
          vm.garantia = response.data.tipoGarantia;
          return response.data;
        })
        .catch(function(response) {
          vm.error = response.data;
          return response.data;
        })
    }
  }
})();
