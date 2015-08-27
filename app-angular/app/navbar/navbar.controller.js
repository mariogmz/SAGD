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
    });

  NavbarController.$inject = ['$auth', 'session'];

  function NavbarController($auth, session) {
    var vm = this;
    vm.modules = [
      {
        nombre: 'Inicio',
        state: 'home',
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
        nombre: 'Paquetes',
        state: 'paquete',
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
    vm.logout = session.logout;
    vm.empleado = JSON.parse(localStorage.empleado);
  }

})();
