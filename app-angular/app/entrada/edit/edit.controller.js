// app/entrada/edit/edit.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.entrada')
    .controller('entradaEditController', entradaEditController);

  entradaEditController.$inject = ['$state', '$stateParams', 'api', 'pnotify', 'utils', 'session'];

  /* @ngInject */
  function entradaEditController($state, $stateParams, api, pnotify, utils, session) {

    var vm = this;

    vm.create = create;
    vm.setClass = utils.setClass;
    vm.back = goBack;
    vm.agregarEntradaDetalle = agregarEntradaDetalle;
    vm.removerEntradaDetalle = removerEntradaDetalle;
    vm.id = $stateParams.id;
    vm.empleado = session.obtenerEmpleado();
    vm.entrada = {};
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

          obtenerEntrada().then(function(response) {
            vm.entrada = response.data.entrada;
            vm.entrada.tipo_cambio = parseFloat(vm.entrada.tipo_cambio);
            vm.entrada.factura = Boolean(vm.entrada.factura);
            vm.entrada.factura_fecha = new Date(vm.entrada.factura_fecha);
            console.log('Entrada obtenida');
          }).catch(function(response) {
            pnotify.alert('Error', 'No se pudo obtener la entrada', 'error');
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

    function obtenerEntrada() {
      return api.get('/entrada/', vm.id);
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
      if (vm.entrada.estado_entrada_id !== 1) {
        pnotify.alert('Entrada esta siendo cargada o ya esta cargada',
          'Ya no puedes agregar mas detalles a entra entrada', 'error');
        return;
      }

      checkIsEntradaDetalleIsValid(entradaDetalle) && appendEntradaDetalle(entradaDetalle);
    }

    function checkIsEntradaDetalleIsValid(entradaDetalle) {
      return (entradaDetalle.cantidad > 0 || entradaDetalle.upc.length > 0);
    }

    function appendEntradaDetalle(entradaDetalle) {
      buscarProducto(entradaDetalle.upc).then(function(responseProducto) {
        entradaDetalle.producto_id = responseProducto.data.producto.id;
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
      for (var i = vm.entrada.detalles.length - 1; i >= 0; i--) {
        if (vm.entrada.detalles[i].producto.id === responseDetalle.producto_id) {
          vm.entrada.detalles[i].cantidad = responseDetalle.cantidad;
          vm.entrada.detalles[i].costo = responseDetalle.costo;
          vm.entrada.detalles[i].importe = responseDetalle.importe;
          return;
        }
      }

      vm.entrada.detalles.push({
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
        for (var i = vm.entrada.detalles.length - 1; i >= 0; i--) {
          var sd = vm.entrada.detalles[i];
          if (sd === entradaDetalle) {
            vm.entrada.detalles.splice(i, 1);
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
