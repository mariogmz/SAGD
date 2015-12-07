// app/pretransferencia/index/index.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.pretransferencia')
    .controller('pretransferenciaIndexController', pretransferenciaIndexController);

  pretransferenciaIndexController.$inject = ['api', 'pnotify', 'modal', 'session', 'printer'];

  /* @ngInject */
  function pretransferenciaIndexController(api, pnotify, modal, session, printer) {

    var vm = this;
    vm.empleado = session.obtenerEmpleado();
    vm.print = print;

    activate();

    ////////////////

    function activate() {
      obtenerPretransferencias().then(function(response) {
        console.log('Pretransferencias obtenidas exitosamente');
        vm.pretransferencias = response.data;
      });
    }

    function obtenerPretransferencias() {
      return api.get('/inventario/pretransferencias/origen/' + vm.empleado.sucursal_id);
    }

    function print(pretransferencia) {
      var origen = pretransferencia.origen.id;
      var destino = pretransferencia.destino.id;
      backendPrint(origen, destino).then(printer.send);
    }

    function backendPrint(origen, destino) {
      return api.get('/inventario/pretransferencias/imprimir/origen/' + origen + '/destino/' + destino, null, true);
    }
  }
})();
