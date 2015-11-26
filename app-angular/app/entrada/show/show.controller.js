// app/entrada/show/show.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.entrada')
    .controller('entradaShowController', entradaShowController);

  entradaShowController.$inject = ['$state', '$stateParams', 'api', 'modal', 'pnotify'];

  /* @ngInject */
  function entradaShowController($state, $stateParams, api, modal, pnotify) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;
    vm.cargar = cargar;
    vm.cargado = cargado;
    vm.subtotal = 0;

    activate();

    ////////////////

    function activate() {
      return obtenerEntrada().then(function(response) {
          console.log(response.message);
          calcularSubtotal();
        });
    }

    function obtenerEntrada() {
      return api.get('/entrada/', vm.id).then(function(response) {
        vm.entrada = response.data.entrada;
        return response.data;
      })
      .catch(function(response) {
        vm.error = response.data;
        return response.data;
      });
    }

    function calcularSubtotal() {
      for (var i = vm.entrada.detalles.length - 1; i >= 0; i--) {
        var detalle = vm.entrada.detalles[i];
        vm.subtotal += detalle.importe;
      };
    }

    function cargar() {
      modal.confirm({
        title: 'Cargar entrada',
        content: 'Estas a punto de cargar la entrada y actualizar existencias. ¿Estás seguro?',
        accept: 'Cargar entrada',
        dismiss: 'Cancelar',
        type: 'danger'
      }).then(function() {
        modal.hide('confirm');
        cargarEntrada().then(function() {
          pnotify.alert('¡Éxito!', 'La entrada fue cargada exitosamente', 'success');
          activate();
        }).catch(function(response) {
          pnotify.alert(response.data.error, response.data.message, 'error');
        });
      }).catch(function() {
        modal.hide('confirm');
        return false;
      });
    }

    function cargarEntrada() {
      return api.get('/entrada/' + vm.entrada.id + '/cargar');
    }

    function cargado() {
      return (vm.entrada && vm.entrada.detalles.length > 0 && vm.entrada.detalles[0].producto_movimiento !== null);
    }

    function goBack() {
      $state.go('entradaIndex');
    }
  }
})();
