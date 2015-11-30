// app/entrada/index/index.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.entrada')
    .controller('entradaIndexController', entradaIndexController);

  entradaIndexController.$inject = ['api', 'pnotify', 'modal'];

  /* @ngInject */
  function entradaIndexController(api, pnotify, modal) {

    var vm = this;
    vm.sort = sort;
    vm.eliminarEntrada = eliminar;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Proveedor', key: 'proveedor.razon_social'},
      {name: '# Factura', key: 'factura_extena_numero'},
      {name: 'Fecha Factura', key: 'factura_fecha'},
      {name: 'Fecha de alta', key: 'created_at'},
      {name: 'Estatus', key: 'estado.nombre'},
      {name: 'Receptor de factura', key: 'razonSocial.razon_social'},
      {name: 'Recibe', key: 'empleado.nombre'},
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerEntradas().then(function() {
        console.log('Entradas obtenidas');
      });
    }

    function obtenerEntradas() {
      return api.get('/entrada').then(function(response) {
          vm.entradas = response.data;
          return vm.entradas;
        });
    }

    function eliminar(entrada) {
      (entrada.estado_entrada_id == 1) &&
      modal.confirm({
        title: 'Eliminar Entrada',
        content: 'Estas a punto de eliminar una entrada. ¿Estás seguro?',
        accept: 'Eliminar Entrada',
        type: 'danger'
      })
      .then(function(response) {
        modal.hide('confirm');
        eliminarEntrada(entrada.id);
      })
      .catch(function(response) {
        modal.hide('confirm');
        return false;
      });
    }

    function eliminarEntrada(id) {
      return api.delete('/entrada/', id)
        .then(function(response) {
          obtenerEntradas().then(function() {
            pnotify.alert('¡Éxito!', response.data.message, 'success');
          });
        })
        .catch(function(response) {
          pnotify.alert('¡Error!', response.data.message, 'error');
        });
    }

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }
})();
