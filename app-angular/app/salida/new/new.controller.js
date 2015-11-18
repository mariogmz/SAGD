// app/salida/new/new.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .controller('salidaNewController', salidaNewController);

  salidaNewController.$inject = ['$state', 'api', 'pnotify', 'utils', 'session'];

  /* @ngInject */
  function salidaNewController($state, api, pnotify, utils, session) {

    var vm = this;

    vm.create = create;
    vm.setClass = utils.setClass;
    vm.back = goBack;
    vm.agregarSalidaDetalle = agregarSalidaDetalle;
    vm.removerSalidaDetalle = removerSalidaDetalle;
    vm.empleado = session.obtenerEmpleado();
    vm.salida = {
      fecha_salida: new Date(),
      salidas_detalles: [],
      estado_salida_id: 1,
      empleado_id: vm.empleado.id,
      sucursal_id: vm.empleado.sucursal_id
    };

    activate();

    ////////////////

    function activate() {
    }

    function create() {
      (vm.salida.salidas_detalles.length > 0) &&
      api.post('/salida', vm.salida)
        .then(function(response) {
          pnotify.alert('Exito', response.data.message, 'success');
          $state.go('salidaShow', {id: response.data.salida.id});
        })
        .catch(function(response) {
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function agregarSalidaDetalle(salidaDetalle) {
      checkIsSalidaDetalleIsValid(salidaDetalle) && appendSalidaDetalle(salidaDetalle);
    }

    function checkIsSalidaDetalleIsValid(salidaDetalle) {
      if (salidaDetalle.cantidad <= 0 || salidaDetalle.upc.length <= 0) {
        return false;
      }

      return true;
    }

    function appendSalidaDetalle(salidaDetalle) {
      buscarProducto(salidaDetalle.upc).then(function(response) {
        vm.salida.salidas_detalles.push({
          cantidad: salidaDetalle.cantidad,
          producto: response.data.producto
        });
      }).catch(function(response) {
        pnotify.alert('Detalle no agregado', response.data.error, 'error');
      });
    }

    function buscarProducto(upc) {
      return api.get('/producto/buscar/upc/', upc);
    }

    function removerSalidaDetalle(salidaDetalle) {
      for (var i = vm.salida.salidas_detalles.length - 1; i >= 0; i--) {
        var sd = vm.salida.salidas_detalles[i];
        if (sd === salidaDetalle) {
          vm.salida.salidas_detalles.splice(i, 1);
          break;
        }
      }
    }

    function goBack() {
      window.history.back();
    }
  }
})();
