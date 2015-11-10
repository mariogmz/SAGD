// app/salida/new/new.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .controller('salidaNewController', salidaNewController);

  salidaNewController.$inject = ['$state', 'api', 'pnotify', 'utils'];

  /* @ngInject */
  function salidaNewController($state, api, pnotify, utils) {

    var vm = this;

    vm.create = create;
    vm.setClass = utils.setClass;
    vm.back = goBack;
    vm.agregarSalidaDetalle = agregarSalidaDetalle;
    vm.salida = {
      fecha_salida: new Date(),
      salidas_detalles: [
        {
          cantidad: 0,
          upc: ''
        }
      ]
    };

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

    function agregarSalidaDetalle() {
      checkIfSalidasDetallesHasEmptySets() && vm.salida.salidas_detalles.push({
        cantidad: 0,
        upc: ''
      });
    }

    function checkIfSalidasDetallesHasEmptySets() {
      for (var i = vm.salida.salidas_detalles.length - 1; i >= 0; i--) {
        if (vm.salida.salidas_detalles[i].upc === '') {
          return false;
        } else if (vm.salida.salidas_detalles[i].cantidad === 0) {
          return false;
        }
      }

      return true;
    }

    function goBack() {
      window.history.back();
    }
  }
})();
