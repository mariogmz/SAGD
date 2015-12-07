// app/transferencia/index/transferencia.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.transferencia')
    .controller('transferenciaIndexController', transferenciaIndexController);

  transferenciaIndexController.$inject = ['$state', 'api', 'pnotify', 'session'];

  function transferenciaIndexController($state, api, pnotify, session) {

    var vm = this;
    vm.sortKeys = [
      {name: 'ID', key: 'id'},
      {name: 'Fecha', key: 'created_at'},
      {name: 'Origen', key: 'sucursalOrigen.nombre'},
      {name: 'Destino', key: 'sucursalDestino.nombre'},
      {name: 'Crea', key: 'empleadoOrigen.nombre'},
      {name: 'Recibe', key: 'empleadoDestino.nombre'},
      {name: 'Estatus', key: 'estado.nombre'},
      {name: 'Reviso', key: 'empleadoRevision.nombre'},
    ];
    vm.empleado = session.obtenerEmpleado();

    vm.sort = sort;
    vm.back = goBack;
    vm.eliminar = eliminar;
    vm.editable = editable;
    vm.eliminable = eliminable;
    vm.transferible = transferible;

    initialize();

    function initialize() {
      obtenerSalidas().then(function(response) {
        vm.salidas = response.data;
      });

      obtenerEntradas().then(function(response) {
        vm.entradas = response.data;
      });

      $state.go('transferenciaIndex.tabs');
    }

    function obtenerSalidas() {
      return api.get('/transferencias/salidas');
    }

    function obtenerEntradas() {
      return api.get('/transferencias/entradas');
    }

    function error(response) {
      console.log('Hubo un error con la peticion.');
      pnotity.alert('Error', response.data.message, 'error');
    }

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

    function goBack() {
      window.history.back();
    }

    function eliminar(id) {
      return api.delete('/transferencias/eliminar/' + id).then(function(response) {
        console.log('Transferencia eliminada exitosamente');
        pnotity.alert('Exito', response.data.message, 'success');
      }).catch(function(response) {
        pnotity.alert(response.data.message, response.data.error, 'error');
      });
    }

    function editable(id) {
      // De acuerdo con los estados de transferencia, los estados 3 y 5 son inmutables
      return id !== 3 && id !== 5;
    }

    function eliminable(id) {
      // De acuerdo con los estados de transferencia, solo el estado 1 es eliminable
      return id === 1;
    }

    function transferible(id) {
      // De acuerdo con los estados de transferencia, el estado de Cargando Origen es transferible
      return id === 2;
    }
  }
})();
