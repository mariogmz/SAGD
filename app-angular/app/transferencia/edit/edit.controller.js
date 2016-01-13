// app/transferencia/edit/edit.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.transferencia')
    .controller('transferenciaEditController', transferenciaEditController);

  transferenciaEditController.$inject = ['$stateParams', 'api', 'session'];

  /* @ngInject */
  function transferenciaEditController($stateParams, api, session) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.empleado = session.obtenerEmpleado();
    vm.back = goBack;
    vm.agregarDetalle = agregar;
    vm.removerDetalle = remover;
    vm.detalle = {
      cantidad: 1,
      upc: ''
    };

    activate();

    ////////////////

    function activate() {
      obtenerTransferencia().then(function(response) {
        console.log('Transferencia obtenida exitosamente');
        vm.transferencia = response.data.transferencia;
      });
    }

    function obtenerTransferencia() {
      return api.get('/transferencias/salidas/ver/' + vm.id);
    }

    function agregar() {
      buscarProducto().then(function(producto) {
        vm.detalle.producto_id = producto.data.producto.id;
        setEmpleadoOrigen().then(function() {
          saveDetalle().then(function(response) {
            pushDetalle(response.data.detalle, producto.data.producto);
            resetDetalle();
          });
        });
      });
    }

    function buscarProducto() {
      return api.get('/producto/buscar/upc/', vm.detalle.upc);
    }

    function setEmpleadoOrigen() {
      if (vm.transferencia.detalles.length === 0) {
        var datos = {
          empleado_origen_id: vm.empleado.id,
          estado_transferencia_id: 2 // hardcodeado porque sabemos que el seeder hara el id 2 al de cargando origen
        };
        return api.put('/transferencias/salidas/' + vm.id, '', datos);
      }

      return new Promise(function(resolve, reject) {
        resolve(true);
      });
    }

    function saveDetalle() {
      return api.post('/transferencias/salidas/' + vm.id + '/detalle', vm.detalle);
    }

    function pushDetalle(detalle, producto) {
      for (var i = vm.transferencia.detalles.length - 1; i >= 0; i--) {
        if (vm.transferencia.detalles[i].producto.id === detalle.producto_id) {
          vm.transferencia.detalles[i].cantidad = detalle.cantidad;
          return;
        }
      }

      vm.transferencia.detalles.push({
        id: detalle.id,
        cantidad: detalle.cantidad,
        producto: producto
      });
    }

    function resetDetalle() {
      vm.detalle = {
        cantidad: 1,
        upc: ''
      };
    }

    function remover(detalle) {
      unsaveDetalle(detalle).then(function(response) {
        for (var i = vm.transferencia.detalles.length - 1; i >= 0; i--) {
          var transferenciaDetalle = vm.transferencia.detalles[i];
          if (transferenciaDetalle === detalle) {
            vm.transferencia.detalles.splice(i, 1);
            break;
          }
        }
      });
    }

    function unsaveDetalle(detalle) {
      return api.delete('/transferencias/salidas/' + vm.id + '/detalle/' + detalle.id);
    }

    function goBack() {
      window.history.back();
    }
  }
})();
