// app/blocks/entradas/entradas.directive.js
(function() {
  'use strict';

  angular.module('blocks.entradas')
    .directive('entradas', entradas);

  entradas.$inject = [];

  /* @ngInject */
  function entradas() {
    var directive = {
      bindToController: true,
      controller: EntradasController,
      controllerAs: 'vm',
      link: link,
      scope: {
        productoId: '='
      },
      templateUrl: 'app/templates/components/entradas.html'
    };

    return directive;

    function link(scope, element, attrs) {

    }
  }

  EntradasController.$inject = ['Producto'];

  /* @ngInject */
  function EntradasController(Producto) {
    var vm = this;

    activate();

    //////////////////////////////

    function activate() {
      return obtenerEntradas();
    }

    function obtenerEntradas() {
      return Producto.entradas(vm.productoId)
        .then(function(detallesEntradas) {
          vm.detallesEntradas = detallesEntradas.map(checkCurrencies);
          return detallesEntradas;
        });
    }

    function checkCurrencies(detalle) {
      if (detalle.entrada.tipo_cambio != 1) {
        detalle.costo_dolar = detalle.costo;
      }

      return detalle;
    }
  }
})();
