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
    vm.salidaDetalle = {
      cantidad: 0
    };

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
          pushSalidaDetalle(responseDetalle.data.detalle, responseProducto.data.producto);
          limpiarInputSalidaDetalle();
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
      for (var i = vm.salida.detalles.length - 1; i >= 0; i--) {
        if (vm.salida.detalles[i].producto.id === responseDetalle.producto_id) {
          vm.salida.detalles[i].cantidad = responseDetalle.cantidad;
          return;
        }
      }

      vm.salida.detalles.push({
        id: responseDetalle.id,
        cantidad: responseDetalle.cantidad,
        producto: responseProducto
      });
    }

    function limpiarInputSalidaDetalle() {
      vm.salidaDetalle.cantidad = 0;
      vm.salidaDetalle.upc = '';
    }

    function removerSalidaDetalle(salidaDetalle) {
      unsaveSalidaDetalle(salidaDetalle).then(function(response) {
        for (var i = vm.salida.detalles.length - 1; i >= 0; i--) {
          var sd = vm.salida.detalles[i];
          if (sd === salidaDetalle) {
            vm.salida.detalles.splice(i, 1);
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
