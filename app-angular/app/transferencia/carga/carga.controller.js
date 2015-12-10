// app/transferencia/carga/carga.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.transferencia')
    .controller('transferenciaCargaController', transferenciaCargaController);

  transferenciaCargaController.$inject = ['$stateParams', 'api', 'session', 'utils', 'pnotify', 'modal'];

  /* @ngInject */
  function transferenciaCargaController($stateParams, api, session, utils, pnotify, modal) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.empleado = session.obtenerEmpleado();
    vm.back = goBack;
    vm.agregarDetalle = agregar;
    vm.cargar = cargar;
    vm.resetDetalle = resetRemoteDetalle;
    vm.detalle = {
      cantidad: 1,
      upc: ''
    };
    vm.productos = [];
    vm.upcs = [];

    activate();

    ////////////////

    function activate() {
      resetDetalle();
      obtenerTransferencia().then(function(response) {
        console.log('Transferencia obtenida exitosamente');
        vm.transferencia = response.data.transferencia;
        vm.productos = utils.pluck(vm.transferencia.detalles, 'producto');
        vm.upcs = utils.pluck(vm.productos, 'upc');
      });
    }

    function resetDetalle() {
      vm.detalle = {
        cantidad: 1,
        upc: ''
      };
    }

    function obtenerTransferencia() {
      return api.get('/transferencias/entradas/ver/' + vm.id);
    }

    function agregar() {
      buscarProducto().then(function(response) {
        var producto = response.data.producto;

        return buscarProductoEnDetalles(producto).then(function(index) {

          return agregarCantidadEscaneada(index).then(function(response) {
            isEnTransferencia() && setCargandoDestino();
            success(response);
          });
        });
      }).catch(error);
    }

    function buscarProducto() {
      return api.get('/producto/buscar/upc/', vm.detalle.upc);
    }

    function buscarProductoEnDetalles(producto) {
      for (var i = vm.transferencia.detalles.length - 1; i >= 0; i--) {
        var producto_detalle = vm.transferencia.detalles[i].producto;
        if (producto_detalle.id === producto.id) {
          return Promise.resolve(vm.transferencia.detalles[i].id);
        }
      }

      return Promise.reject({
        data: {
          message: 'El producto no esta en el listado de detalles',
          error: 'Producto no en detalles'
        }
      });
    }

    function agregarCantidadEscaneada(index) {
      return api.post('/transferencias/entradas/' + vm.id + '/detalle/' + index + '/escanear', {cantidad: vm.detalle.cantidad});
    }

    function isEnTransferencia() {
      // De acuerdo con las especificaciones de estados de transferencia, el
      // estado 3 significa que esta "En Transferencia" o "En Transito" lo cual
      // lo convierte en candidato para cambiar de estado a "Cargando Destino"
      return vm.transferencia.estado.id === 3;
    }

    function setCargandoDestino() {
      return api.post('/transferencias/entradas/' + vm.id + '/cargando-destino');
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

    function resetRemoteDetalle(detalle_id) {
      return api.post('/transferencias/entradas/' + vm.id + '/detalle/' + detalle_id + '/reset')
        .then(success).catch(error);
    }

    function success(response) {
      pnotify.alert('Exito', response.data.message, 'success');
      activate();
    }

    function error(response) {
      pnotify.alert(response.data.message, response.data.error, 'error');
    }
  }
})();
