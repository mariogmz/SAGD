// app/blocks/existencias/existencias.directive.js

(function() {
  'use strict';

  angular.module('blocks.existencias')
    .directive('existencias', existencias);

  existencias.$inject = [];

  /* @ngInject */
  function existencias() {
    var directive = {
      bindToController: true,
      controller: ExistenciasController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        productoId: '=',
        empleado: '=',
        readOnly: '='
      },
      templateUrl: 'app/templates/components/existencias.html'
    };

    return directive;

    function link(scope, element, attrs) {

    }
  }

  ExistenciasController.$inject = ['Producto'];

  /* @ngInject */
  function ExistenciasController(Producto) {
    var vm = this;
    vm.guardarPretransferencias = guardarPretransferencias;
    vm.cambiarPretransferenciaMaxima = cambiarPretransferenciaMaxima;
    vm.local = sucursalLocal;
    activate();

    //////////////////////////////

    function activate() {
      vm.readOnly = vm.readOnly || false;
      vm.empleado = vm.empleado || JSON.parse(localStorage.getItem('empleado'));
      return obtenerExistencias()
        .then(function(existencias) {
          return existencias;
        });
    }

    ////////////// API Calls ///////////////

    function obtenerExistencias() {
      return Producto.existencias(vm.productoId)
        .then(function(existencias) {
          vm.existencias = existencias;
          vm.pretransferencias = {};
          setupExistencias();

          return existencias;
        });
    }

    ///////////// UI Behavior /////////////

    function setupExistencias() {
      for (var i = vm.existencias.length - 1; i >= 0; i--) {
        var existencia = vm.existencias[i];
        if (sucursalLocal(existencia)) {
          vm.pretransferenciaMaxima = existencia.cantidad;
        }

        var pretransferencia = {
          id: existencia.productos_sucursales_id,
          cantidad: existencia.cantidad,
          pretransferencia: 0
        };
        vm.pretransferencias[pretransferencia.id] = pretransferencia;
      }
    }

    function solicitarPretransferencia(data) {
      return Producto.pretransferir(vm.productoId, data)
        .then(function(data) {
          if (data) {
            obtenerExistencias();
          }

          return data;
        });
    }

    function sucursalLocal(producto) {
      return vm.empleado.sucursal.nombre === producto.nombre;
    }

    function guardarPretransferencias() {
      vm.pretransferencias = $.map(vm.pretransferencias, function(value, index) {
        return [value];
      });

      vm.pretransferencias.push({sucursal_origen: vm.empleado.sucursal_id});
      vm.pretransferencias.push({empleado_id: vm.empleado.id});

      solicitarPretransferencia(vm.pretransferencias);
    }

    function cambiarPretransferenciaMaxima(productoSucursalId) {
      var suma = 0;
      var cantidad = vm.pretransferencias[productoSucursalId].pretransferencia;

      for (var i = 0; i < vm.existencias.length; i++) {
        if (vm.existencias[i].productos_sucursales_id != productoSucursalId) {
          suma += vm.pretransferencias[vm.existencias[i].productos_sucursales_id].pretransferencia;
        }
      }

      if ((suma + cantidad) > vm.pretransferenciaMaxima) {
        vm.pretransferencias[productoSucursalId].pretransferencia = (vm.pretransferenciaMaxima - suma) > 0 ? vm.pretransferenciaMaxima - suma : 0;
      }

    }

  }
})();
