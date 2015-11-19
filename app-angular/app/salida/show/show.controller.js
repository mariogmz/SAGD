// app/salida/show/show.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.salida')
    .controller('salidaShowController', salidaShowController);

  salidaShowController.$inject = ['$state', '$stateParams', 'api', 'modal', 'pnotify'];

  /* @ngInject */
  function salidaShowController($state, $stateParams, api, modal, pnotify) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;
    vm.cargar = cargar;
    vm.cargado = cargado;

    activate();

    ////////////////

    function activate() {
      return obtenerSalida().then(function(response) {
          console.log(response.message);
        });
    }

    function obtenerSalida() {
      return api.get('/salida/', vm.id).then(function(response) {
        vm.salida = response.data.salida;
        return response.data;
      })
      .catch(function(response) {
        vm.error = response.data;
        return response.data;
      });
    }

    function cargar() {
      modal.confirm({
        title: 'Cargar salida',
        content: 'Estas a punto de cargar la salida y actualizar existencias. ¿Estás seguro?',
        accept: 'Cargar salida',
        dismiss: 'Cancelar',
        type: 'danger'
      }).then(function() {
        modal.hide('confirm');
        cargarSalida().then(function() {
          pnotify.alert('¡Éxito!', 'La salida fue cargada exitosamente', 'success');
          activate();
        }).catch(function() {
          pnotify.alert('Error', 'La salida no fue cargada', 'error');
        });
      }).catch(function() {
        modal.hide('confirm');
        return false;
      });
    }

    function cargarSalida() {
      return api.get('/salida/' + vm.salida.id + '/cargar');
    }

    function cargado() {
      return (vm.salida && vm.salida.detalles.length > 0 && vm.salida.detalles[0].producto_movimiento !== null);
    }

    function goBack() {
      $state.go('salidaIndex');
    }
  }
})();
