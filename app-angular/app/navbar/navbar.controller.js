// app/navbar/navbar.controller.js

(function () {

  'use strict';

  angular
    .module('sagdApp.navbar')
    .controller('NavbarController', NavbarController)
    .directive('navBar', function () {
      return {
        templateUrl: 'app/navbar/navbar.html'
      };
    })
    .filter('capitalize', function(){
      return function(input){
        return input.charAt(0).toUpperCase() + input.substr(1).toLowerCase();
      }
    });

  NavbarController.$inject = ['session'];

  function NavbarController(session) {
    var vm = this;
    vm.modules = [
      {
        nombre: 'Inicio',
        state: 'dashboard',
        active: true
      }, {
        nombre: 'Productos',
        state: 'producto',
        active: false
      }, {
        nombre: 'Clientes',
        state: 'cliente',
        active: false
      }, {
        nombre: 'Facturación',
        state: 'facturacion',
        active: false
      }, {
        nombre: 'Ventas',
        state: 'venta',
        active: false
      }, {
        nombre: 'Gastos',
        state: 'gasto',
        active: false
      }, {
        nombre: 'Garantías',
        state: 'garantia',
        active: false
      }, {
        nombre: 'Empleados',
        state: 'empleado',
        active: false
      }, {
        nombre: 'Web',
        state: 'web',
        active: false
      }, {
        nombre: 'Sistema',
        state: 'sistema',
        active: false
      }
    ];

    vm.isAuthenticated = session.isAuthenticated;
    vm.empleado = session.obtenerEmpleado();
    vm.logout = session.logout;
  }

})();
