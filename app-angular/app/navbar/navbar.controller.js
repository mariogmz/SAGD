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

  NavbarController.$inject = ['session'];

  function NavbarController(session) {
    var vm = this;
    vm.modules = [
      {
        nombre: 'Inicio',
        state: 'home',
        active: true,
        submodules: [
          {
            nombre: 'Inicio',
            state: 'home'
          }
        ]
      }, {
        nombre: 'Productos',
        state: 'producto',
        active: false,
        submodules: [
          {
            nombre: 'Cátalogo',
            state: 'producto/catalogo',
          },{
            nombre: 'Marcas',
            state: 'producto/marca',
          },{
            nombre: 'Familias',
            state: 'producto/familia',
          },{
            nombre: 'Subfamilias',
            state: 'producto/subfamilias',
          }
        ]
      }, {
        nombre: 'Inventario',
        state: 'inventario',
        active: false,
        submodules: [
          {
            nombre: 'Transferencias',
            state: 'producto/transferencia',
          },{
            nombre: 'Un nombre muy muy largo',
            state: 'producto/test',
          }
        ]
      }, {
        nombre: 'Ventas',
        state: 'venta',
        active: false,
        submodules: [
          {
            nombre: 'Ventas',
            state: 'venta',
          },{
            nombre: 'Consultar',
            state: 'venta/consulta',
          },{
            nombre: 'Cotizaciones',
            state: 'venta/cotizacion',
          },{
            nombre: 'Utilidad',
            state: 'venta/utilidad',
          }
        ]
      }, {
        nombre: 'Clientes',
        state: 'cliente',
        active: false,
        submodules: [
          {
            nombre: 'Listar',
            state: 'cliente',
          }
        ]
      }, {
        nombre: 'Proveedores',
        state: 'proveedor',
        active: false,
        submodules: [
          {
            nombre: 'Listar',
            state: 'proveedor',
          }
        ]
      }, {
        nombre: 'Soporte',
        state: 'soporte',
        active: false,
        submodules: [
          {
            nombre: 'Listar',
            state: 'soporte',
          }
        ]
      }, {
        nombre: 'Empleados',
        state: 'empleado',
        active: false,
        submodules: [
          {
            nombre: 'Listar',
            state: 'empleado',
          }
        ]
      }, {
        nombre: 'Cajas y Cortes',
        state: 'caja_corte',
        active: false,
        submodules: [
          {
            nombre: 'Listar cajas',
            state: 'caja_corte/caja'
          },{
            nombre: 'Corte de Caja',
            state: 'caja_corte',
          }
        ]
      }, {
        nombre: 'Paqueterías',
        state: 'paqueteria',
        active: false,
        submodules: [
          {
            nombre: 'Listar',
            state: 'paqueteria'
          }
        ]
      } , {
        nombre: 'Facturación',
        state: 'facturacion',
        active: false,
        submodules: [
          {
            nombre: 'Consultar',
            state: 'facturacion'
          },{
            nombre: 'Reportes',
            state: 'facturacion/reporte'
          },{
            nombre: 'Efectivo',
            state: 'facturacion/efectivo'
          },{
            nombre: 'Administrar folios',
            state: 'facturacion/folio'
          },{
            nombre: 'VM',
            state: 'facturacion/VM'
          },
        ]
      } , {
        nombre: 'Configuración',
        state: 'configuracion',
        active: false,
        submodules: [
          {
            nombre: 'Sucursales',
            state: 'configuracion/sucursal'
          },{
            nombre: 'Logs',
            state: 'configuracion/logs'
          },{
            nombre: 'PM',
            state: 'configuracion/pm'
          },{
            nombre: 'Tipo de Cambio',
            state: 'configuracion/tipocambio'
          }
        ]
      }
    ];

    vm.isAuthenticated = session.isAuthenticated;
    vm.empleado = session.obtenerEmpleado();
    vm.logout = session.logout;
  }

})();
