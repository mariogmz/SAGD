(function() {
  'use strict';

  angular
    .module('sagdApp.inventario')
    .controller('InventarioController', InventarioController);

  InventarioController.$inject = [];

  /* @ngInject */
  function InventarioController() {
    var vm = this;
    vm.title = 'InventarioController';

    activate();

    ////////////////

    function activate() {
      vm.elements = [
        {label: 'Existencias', state: 'producto.existencia', picUrl: '', icon: 'archive'},
        {label: 'Entradas', state: 'entradaIndex', picUrl: '', icon: 'long-arrow-left'},
        {label: 'Salidas', state: 'salidaIndex', picUrl: '', icon: 'long-arrow-right'},
        {label: 'Transferencias', state: 'transferenciaIndex', picUrl: '', icon: 'exchange'},
        {label: 'Por transferir', state: 'pretransferenciaIndex', picUrl: '', icon: 'share'},
        {label: 'Apartados', state: 'apartadoIndex', picUrl: '', icon: 'reorder'},
        {label: 'Resurtir', state: 'resutir', picUrl: '', icon: 'repeat'},
        {label: 'Movimientos', state: 'producto.movimiento', picUrl: '', icon: 'list-alt'}
      ];
    }
  }

})();

