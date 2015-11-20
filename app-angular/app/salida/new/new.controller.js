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
      motivo: 'Motivo de salida',
      salidas_detalles: [],
      estado_salida_id: 1,
      empleado_id: vm.empleado.id,
      sucursal_id: vm.empleado.sucursal_id
    };

    activate();

    ////////////////

    function activate() {
      saveSalida().then(function(response) {
        vm.salida.id = response.data.salida.id;
        console.log('Salida preguardada');
      }).catch(function(response) {
        pnotify.alert('Error', 'No se pudo pre-guardar la salida', 'error');
        $state.go('salidaIndex');
      });
    }

    function saveSalida() {
      return api.post('/salida', vm.salida);
    }

    function create() {
      verifyMotivo() &&
      api.put('/salida/', vm.salida.id, vm.salida)
      .then(function(response) {
        pnotify.alert('Exito', response.data.message, 'success');
        $state.go('salidaShow', {id: response.data.salida.id});
      })
      .catch(function(response) {
        pnotify.alertList(response.data.message, response.data.error, 'error');
      });
    }

    function verifyMotivo() {
      if (vm.salida.motivo === 'Motivo de salida') {
        pnotify.alert('Error', 'Motivo de salida permaneció intacto', 'error');
        return false;
      } else {
        return true;
      }
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
          pushSalidaDetalle(responseDetalle.data.detalle, responseProducto.data.producto);
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

    function pushSalidaDetalle(responseDetalle, responseProducto) {
      for (var i = vm.salida.salidas_detalles.length - 1; i >= 0; i--) {
        if (vm.salida.salidas_detalles[i].producto.id === responseDetalle.producto_id) {
          vm.salida.salidas_detalles[i].cantidad = responseDetalle.cantidad;
          return;
        }
      }

      vm.salida.salidas_detalles.push({
        id: responseDetalle.id,
        cantidad: responseDetalle.cantidad,
        producto: responseProducto
      });
    }

    function removerSalidaDetalle(salidaDetalle) {
      unsaveSalidaDetalle(salidaDetalle).then(function(response) {
        for (var i = vm.salida.salidas_detalles.length - 1; i >= 0; i--) {
          var sd = vm.salida.salidas_detalles[i];
          if (sd === salidaDetalle) {
            vm.salida.salidas_detalles.splice(i, 1);
            break;
          }
        }
      });
    }

    function unsaveSalidaDetalle(salidaDetalle) {
      return api.delete('/salida/' + vm.salida.id + '/detalles/' + salidaDetalle.id);
    }

    function goBack() {
      window.history.back();
    }
  }
})();
