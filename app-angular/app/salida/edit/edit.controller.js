// app/salida/edit/edit.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .controller('salidaEditController', salidaEditController);

  salidaEditController.$inject = ['$state', '$stateParams', 'api', 'pnotify', 'utils', 'session'];

  /* @ngInject */
  function salidaEditController($state, $stateParams, api, pnotify, utils, session) {

    var vm = this;

    vm.create = create;
    vm.setClass = utils.setClass;
    vm.back = goBack;
    vm.agregarSalidaDetalle = agregarSalidaDetalle;
    vm.removerSalidaDetalle = removerSalidaDetalle;
    vm.id = $stateParams.id;
    vm.empleado = session.obtenerEmpleado();
    vm.salida = {};

    activate();

    ////////////////

    function activate() {
      obtenerSalida().then(function(response) {
        vm.salida = response.data.salida;
        vm.salida.fecha_salida = new Date(vm.salida.fecha_salida);
        console.log('Salida obtenida');
      }).catch(function(response) {
        pnotify.alert('Error', 'No se pudo obtener la salida', 'error');
        $state.go('salidaIndex');
      });
    }

    function obtenerSalida() {
      return api.get('/salida/', vm.id);
    }

    function create() {
      api.put('/salida/', vm.salida.id, vm.salida)
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
      return (salidaDetalle.cantidad > 0 || salidaDetalle.upc.length > 0);
    }

    function appendSalidaDetalle(salidaDetalle) {
      buscarProducto(salidaDetalle.upc).then(function(responseProducto) {
        salidaDetalle.producto_id = responseProducto.data.producto.id;
        saveSalidaDetalle(salidaDetalle).then(function(responseDetalle) {
          vm.salida.salidas_detalles.push({
            cantidad: salidaDetalle.cantidad,
            producto: responseProducto.data.producto
          });
        });
      }).catch(function(response) {
        pnotify.alert('Detalle no agregado', response.data.error, 'error');
      });
    }

    function buscarProducto(upc) {
      return api.get('/producto/buscar/upc/', upc);
    }

    function saveSalidaDetalle(salidaDetalle) {
      return api.post('/salida/' + vm.salida.id + '/detalles', salidaDetalle);
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
