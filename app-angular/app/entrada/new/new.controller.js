// app/entrada/new/new.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.entrada')
    .controller('entradaNewController', entradaNewController);

  entradaNewController.$inject = ['$state', 'api', 'pnotify', 'utils', 'session'];

  /* @ngInject */
  function entradaNewController($state, api, pnotify, utils, session) {

    var vm = this;

    vm.create = create;
    vm.setClass = utils.setClass;
    vm.back = goBack;
    vm.agregarEntradaDetalle = agregarEntradaDetalle;
    vm.removerEntradaDetalle = removerEntradaDetalle;
    vm.empleado = session.obtenerEmpleado();
    vm.entrada = {
      factura_externa_numero: '-',
      factura_fecha: new Date(),
      moneda: 'PESOS',
      tipo_cambio: 1.0,
      factura: true,
      entradas_detalles: [],
      estado_entrada_id: 1,
      empleado_id: vm.empleado.id,
      sucursal_id: vm.empleado.sucursal_id
    };
    vm.entradaDetalle = {
      cantidad: 0,
      costo: 0.0,
      importe: 0.0
    };

    activate();

    ////////////////

    function activate() {
      obtenerProveedores().then(function(response) {
        vm.proveedores = response.data;

        obtenerRazonSocialEmisor().then(function(response) {
          vm.razones_sociales = response.data;

          vm.entrada.proveedor_id = vm.proveedores[0].id;
          vm.entrada.razon_social_id = vm.razones_sociales[0].id;

          saveEntrada().then(function(response) {
            vm.entrada.id = response.data.entrada.id;
            console.log('Entrada preguardada');
          }).catch(function(response) {
            pnotify.alert('Error', 'No se pudo pre-guardar la entrada', 'error');
            $state.go('entradaIndex');
          });
        });
      });
    }

    function obtenerProveedores() {
      return api.get('/proveedor');
    }

    function obtenerRazonSocialEmisor() {
      return api.get('/emisor/entrada');
    }

    function saveEntrada() {
      return api.post('/entrada', vm.entrada);
    }

    function create() {
      api.put('/entrada/', vm.entrada.id, vm.entrada)
        .then(function(response) {
          pnotify.alert('Exito', response.data.message, 'success');
          $state.go('entradaShow', {id: response.data.entrada.id});
        })
        .catch(function(response) {
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function agregarEntradaDetalle(entradaDetalle) {
      checkIsEntradaDetalleIsValid(entradaDetalle) && appendEntradaDetalle(entradaDetalle);
    }

    function checkIsEntradaDetalleIsValid(entradaDetalle) {
      return (entradaDetalle.cantidad > 0 || entradaDetalle.upc.length > 0);
    }

    function appendEntradaDetalle(entradaDetalle) {
      buscarProducto(entradaDetalle.upc).then(function(responseProducto) {
        entradaDetalle.producto_id = responseProducto.data.producto.id;
        entradaDetalle.importe = entradaDetalle.cantidad * entradaDetalle.costo;
        saveEntradaDetalle(entradaDetalle).then(function(responseDetalle) {
          pushEntradaDetalle(responseDetalle.data.detalle, responseProducto.data.producto);
          limpiarInputEntradaDetalle();
        });
      }).catch(function(response) {
        pnotify.alert('Detalle no agregado', response.data.error, 'error');
      });
    }

    function buscarProducto(upc) {
      return api.get('/producto/buscar/upc/', upc);
    }

    function saveEntradaDetalle(entradaDetalle) {
      return api.post('/entrada/' + vm.entrada.id + '/detalles', entradaDetalle);
    }

    function pushEntradaDetalle(responseDetalle, responseProducto) {
      for (var i = vm.entrada.entradas_detalles.length - 1; i >= 0; i--) {
        if (vm.entrada.entradas_detalles[i].producto.id === responseDetalle.producto_id) {
          vm.entrada.entradas_detalles[i].cantidad = responseDetalle.cantidad;
          vm.entrada.entradas_detalles[i].costo = responseDetalle.costo;
          vm.entrada.entradas_detalles[i].importe = responseDetalle.importe;
          return;
        }
      }

      vm.entrada.entradas_detalles.push({
        id: responseDetalle.id,
        cantidad: responseDetalle.cantidad,
        costo: responseDetalle.costo,
        importe: responseDetalle.importe,
        producto: responseProducto
      });
    }

    function limpiarInputEntradaDetalle() {
      vm.entradaDetalle.cantidad = 0;
      vm.entradaDetalle.costo = 0.0;
      vm.entradaDetalle.importe = 0;
      vm.entradaDetalle.upc = '';
    }

    function removerEntradaDetalle(entradaDetalle) {
      unsaveEntradaDetalle(entradaDetalle).then(function(response) {
        for (var i = vm.entrada.entradas_detalles.length - 1; i >= 0; i--) {
          var sd = vm.entrada.entradas_detalles[i];
          if (sd === entradaDetalle) {
            vm.entrada.entradas_detalles.splice(i, 1);
            break;
          }
        }
      });
    }

    function unsaveEntradaDetalle(entradaDetalle) {
      return api.delete('/entrada/' + vm.entrada.id + '/detalles/' + entradaDetalle.id);
    }

    function goBack() {
      window.history.back();
    }
  }
})();
