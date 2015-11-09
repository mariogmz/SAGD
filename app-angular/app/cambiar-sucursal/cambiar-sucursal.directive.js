// app/cambiar-sucursal/cambiar-sucursal.directive.js

(function() {
  'use strict';

  angular
  .module('sagdApp.cambiar-sucursal')
  .directive('cambiarSucursal', cambiarSucursalDirective);

  cambiarSucursalDirective.$inject = ['session'];

  /* @ngInject */
  function cambiarSucursalDirective(session) {
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
    var sucursal = session.obtenerEmpleado().sucursal;
    var target = $("li.module-list-item.list-item.empleado");

    switch(sucursal.clave) {
      case "DICOTAGS":
        target.css({'background-color': "#0073EA"});
        break;
      case "DICOLEON":
        target.css({'background-color': "#FF6C00"});
        break;
      case "ZEGUCZAC":
        target.css({'background-color': "#00CCCC"});
        break;
      default:
        target.css({'background-color': "#D22D32"});
        break;
    }
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
      return api.get('/sucursal/proveedor/DICO').then(function(response){
        vm.sucursales = response.data;
        return response;
      });
    }

    function isCurrentSucursal(sucursal) {
      return sucursal.id === vm.empleadoActual.sucursal_id;
    }

    function cambiarSucursal(sucursal) {
      cambiarSucursalDeEmpleado(vm.empleadoActual.id, sucursal.id).then(function(){
        session.resetEmpleado().then(function() {
          location.reload();
        });
      })
      .catch(function(response){
        pnotify.alert('Error', response.data.error, 'error');
      });
    }

    function cambiarSucursalDeEmpleado(empleadoId, sucursalId) {
      return api.post('/empleado/' + empleadoId + '/sucursal/' + sucursalId);
    }
  }
})();
