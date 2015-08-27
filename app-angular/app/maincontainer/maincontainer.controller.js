// app/navbar/maincontainer.controller.js

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
        nombre: 'Inventario',
        state: 'inventario',
        active: false
      }, {
        nombre: 'Ventas',
        state: 'venta',
        active: false
      }, {
        nombre: 'Clientes',
        state: 'cliente',
        active: false
      }, {
        nombre: 'Proveedores',
        state: 'proveedor',
        active: false
      }, {
        nombre: 'Soporte',
        state: 'soporte',
        active: false
      }, {
        nombre: 'Empleados',
        state: 'empleado',
        active: false
      }, {
        nombre: 'Cajas y Cortes',
        state: 'caja_corte',
        active: false
      }, {
        nombre: 'Paqueterías',
        state: 'paqueteria',
        active: false
      }, {
        nombre: 'Facturación',
        state: 'facturacion',
        active: false
      }, {
        nombre: 'Configuración',
        state: 'configuracion',
        active: false
      }
    ];

    vm.isAuthenticated = session.isAuthenticated;
    vm.logout = session.logout;
    vm.empleado = session.getEmpleado();
  }

})();
