// app/transferencia/carga/carga.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.transferencia')
    .controller('transferenciaCargaController', transferenciaCargaController);

  transferenciaCargaController.$inject = ['$stateParams', 'api', 'session', 'utils'];

  /* @ngInject */
  function transferenciaCargaController($stateParams, api, session, utils) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.empleado = session.obtenerEmpleado();
    vm.back = goBack;
    vm.agregarDetalle = agregar;
    vm.cargar = cargar;
    vm.detalle = {
      cantidad: 1,
      upc: ''
    };
    vm.productos = [];
    vm.upcs = [];

    activate();

    ////////////////

    function activate() {
      obtenerTransferencia().then(function(response) {
        console.log('Transferencia obtenida exitosamente');
        vm.transferencia = response.data.transferencia;
        vm.productos = utils.pluck(vm.transferencia.detalles, 'producto');
        vm.upcs = utils.pluck(vm.productos, 'upc');
        for (var i = vm.transferencia.detalles.length - 1; i >= 0; i--) {
          vm.transferencia.detalles[i].cantidad_escaneada = 0;
        }
      });
    }

    function obtenerTransferencia() {
      return api.get('/transferencias/salidas/ver/' + vm.id);
    }

    function agregar() {
      if (buscarProducto()) {
        agregarCantidadEscaneada();
        resetDetalle();
      }
    }

    function buscarProducto() {
      if (vm.upcs.length > 0 && vm.upcs.indexOf(vm.detalle.upc > -1)) {
        return true;
      } else {
        return false;
      }
    }

    function agregarCantidadEscaneada() {
      for (var i = vm.transferencia.detalles.length - 1; i >= 0; i--) {
        var producto = vm.transferencia.detalles[i].producto;
        if (producto.upc === vm.detalle.upc) {
          if (vm.transferencia.detalles[i].cantidad_escaneada < vm.transferencia.detalles[i].cantidad) {
            vm.transferencia.detalles[i].cantidad_escaneada += vm.detalle.cantidad;
          }
        }
      }
    }

    function resetDetalle() {
      vm.detalle = {
        cantidad: 1,
        upc: ''
      };
    }

    function goBack() {
      window.history.back();
    }

    function cargar() {
      revisarProductosEscaneados().then(function() {
        modal.confirm({
          title: 'Cargar transferencia',
          content: 'Estas a punto de marcar la transferencia como cargada, esto actualizara las existencias locales. ¿Estás seguro que deseas continuar?',
          accept: 'Cargar transferencia',
          type: 'danger'
        }).then(function() {
          modal.hide('confirm');
          var payload = {
            empleado_id: vm.empleado.id
          };
          return api.post('/transferencias/entradas/cargar/' + vm.id, payload).then(success).catch(error);
        }).catch(function() {
          modal.hide('confirm');
          return false;
        });
      });
    }

    function revisarProductosEscaneados() {
      for (var i = vm.transferencia.detalles.length - 1; i >= 0; i--) {
        if (vm.transferencia.detalles[i].cantidad_escaneada !== vm.transferencia.detalles[i].cantidad) {
          return Promise.reject(false);
        }
      }

      return Promise.resolve(true);
    }

    function success(response) {
      pnotify.alert('Exito', response.data.message, 'success');
      initialize();
    }

    function error(response) {
      pnotify.alert(response.data.message, response.data.error, 'error');
    }
  }
})();
