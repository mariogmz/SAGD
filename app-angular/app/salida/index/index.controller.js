// app/salida/index/index.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .controller('salidaIndexController', salidaIndexController);

  salidaIndexController.$inject = ['api', 'pnotify', 'modal'];

  /* @ngInject */
  function salidaIndexController(api, pnotify, modal) {

    var vm = this;
    vm.sort = sort;
    vm.eliminarUnidad = eliminar;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Fecha', key: 'fecha_salida'},
      {name: 'Motivo', key: 'motivo'},
      {name: 'Empleado', key: 'empleado.usuario'},
      {name: 'Estado', key: 'estado.nombre'},
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerSalidas().then(function() {
        console.log('Salidas obtenidas');
      });
    }

    function obtenerSalidas() {
      return api.get('/salida').then(function(response) {
          vm.salidas = response.data;
          return vm.salidas;
        });
    }

    function eliminar(salida) {
      modal.confirm({
        title: 'Eliminar Salida',
        content: 'Estas a punto de eliminar una salida. ¿Estás seguro?',
        accept: 'Eliminar Salida',
        type: 'danger'
      })
      .then(function(response) {
        modal.hide('confirm');
        eliminarSalida(salida.id);
      })
      .catch(function(response) {
        modal.hide('confirm');
        return false;
      });
    }

    function eliminarSalida(id) {
      return api.delete('/unidad/', id)
        .then(function(response) {
          obtenerSalidas().then(function() {
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
