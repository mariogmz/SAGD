(function() {
  'use strict';

  angular
    .module('blocks.precios')
    .directive('precios', precios);

  precios.$inject = [];

  /* @ngInject */
  function precios() {
    var directive = {
      bindToController: true,
      controller: PreciosController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        producto: '=',
        form: '='
      },
      templateUrl: 'app/templates/components/precios.html'
    };
    return directive;

    function link(scope, element, attrs) {

    }
  }

  PreciosController.$inject = ['utils', 'Precio', 'Margen'];

  /* @ngInject */
  function PreciosController(utils, Precio, Margen) {
    var vm = this;
    vm.sort = sort;
    vm.calcularPrecios = calcularPrecios;
    vm.calcularPreciosMargen = calcularPreciosMargen;

    activate();

    function activate() {
      vm.sortKeys = [
        {name: 'Proveedor', key: 'clave'},
        {name: 'Costo', key: 'costo'},
        {name: 'P1', key: 'precio_1'},
        {name: 'P2', key: 'precio_2'},
        {name: 'P3', key: 'precio_3'},
        {name: 'P4', key: 'precio_4'},
        {name: 'P5', key: 'precio_5'},
        {name: 'P6', key: 'precio_6'},
        {name: 'P7', key: 'precio_7'},
        {name: 'P8', key: 'precio_8'},
        {name: 'P9', key: 'precio_9'},
        {name: 'P10', key: 'precio_10'},
        {name: 'Dcto%', key: 'descuento'}
      ];
      vm.setClass = vm.form ? utils.setClass : angular.noop;
      preciosRevisados();
      obtenerMargenes();
    }

    function obtenerMargenes() {
      return Margen.all()
        .then(function(margenes) {
          vm.margenes = margenes;
        });
    }

    function calcularPrecios(index) {
      var params = [
        {key: 'precio', value: vm.producto.precios[index].precio_1},
        {key: 'costo', value: vm.producto.precios[index].costo},
        {key: 'margen_id', value: vm.producto.margen_id},
        {key: 'externo', value: vm.producto.precios[index].externo}
      ];
      obtenerNuevosPrecios(params);
    }

    function calcularPreciosMargen() {
      var cantidadProveedores = vm.producto.precios.length;
      for (var i = 0; i < cantidadProveedores; i++) {
        calcularPrecios(i);
      }
    }

    //////////////// UTILS /////////////////

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

    function preciosRevisados() {
      vm.producto.margen = vm.producto.margen || {name: 'Libre'};
      vm.producto.revisado = true;
      vm.producto.precios.forEach(function(precio) {
        vm.producto.revisado = vm.producto.revisado && precio.revisado;
        precio.descuento *= 100;
      });
    }

    function obtenerNuevosPrecios(params) {
      return Precio.calcular(params)
        .then(function(resultado) {
          asignarResultado(resultado);
          return resultado;
        });
    }

  }

})();

