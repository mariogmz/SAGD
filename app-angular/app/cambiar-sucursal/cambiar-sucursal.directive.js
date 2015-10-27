// app/cambiar-sucursal/cambiar-sucursal.directive.js

(function() {
  'use strict';

  angular
  .module('sagdApp.cambiar-sucursal')
  .directive('cambiarSucursal', cambiarSucursalDirective);

  cambiarSucursalDirective.$inject = [];

  /* @ngInject */
  function cambiarSucursalDirective() {
    // Usage:
    //
    // Creates:
    //
    var directive = {
      bindToController: true,
      controller: cambiarSucursalController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
      },
      templateUrl: 'app/cambiar-sucursal/cambiar-sucursal.template.html'
  };
  return directive;

  function link(scope, element, attrs) {
  }
}

  cambiarSucursalController.$inject = ['$state', 'session', 'api', 'modal', 'pnotify'];

  /* @ngInject */
  function cambiarSucursalController($state, session, api, modal, pnotify) {
    var vm = this;
    vm.sucursales = [];
    vm.empleadoActual = session.obtenerEmpleado();
    vm.isCurrent = isCurrentSucursal;
    vm.cambiarSucursal = cambiarSucursal;

    activate();

    ////////////////

    function activate() {
      obtenerSucursales().then(function(){
        console.log("Sucursales para cambio de sucursal obtenidas");
      });
    }

    function obtenerSucursales() {
      return api.get('/sucursal?proveedor_clave=DICO').then(function(response){
        vm.sucursales = response.data;
        return response;
      });
    }

    function isCurrentSucursal(sucursal) {
      return sucursal.id === vm.empleadoActual.sucursal_id;
    }

    function cambiarSucursal(sucursal) {
      vm.empleadoActual.sucursal_id = sucursal.id;
      guardarEmpleado().then(function(){
        session.resetEmpleado().then(function() {
          location.reload();
        });
      })
      .catch(function(response){
        pnotify.alert('Error', response.data.message, 'error');
      });
    }

    function guardarEmpleado() {
      return api.put('/empleado/', vm.empleadoActual.id, vm.empleadoActual);
    }
  }
})();
