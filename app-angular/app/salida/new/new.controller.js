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
    vm.isValid = isValid;
    vm.isInvalid = isInvalid;
    vm.salida = {
      fecha_salida: new Date(),
      salidas_detalles: []
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

    function isValid(salidaDetalle) {
      if (salidaDetalle.cantidad <= 0) {
        return false;
      }

      return true;

      // TODO checar en la API si la el producto con el UPC existe y si las existencias son mayores a cantidad
    }

    function isInvalid(salidaDetalle) {
      return !isValid(salidaDetalle);
    }

    function goBack() {
      window.history.back();
    }
  }
})();
