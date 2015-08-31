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

  NavbarController.$inject = ['session', 'state', 'utils'];

  function NavbarController(session, state, utils) {
    var vm = this;
    vm.modules = [
      {
        nombre: 'Inicio',
        state: 'home',
        active: false,
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

    vm.setActiveState = function () {
      var current_state = state.current_state();
      var states = utils.pluck(vm.modules, "state");
      var index = states.indexOf(current_state);
      vm.modules[index].active = true;
    }
    vm.setActiveState();

    vm.clicked = function($event) {
      $('li.module-navbar').each(function () {
        $(this).removeClass('active');
      });
      $($event.currentTarget).addClass('active');
    }

    vm.expandMenu = function($event) {
      MobileNavbarAnimations.animate($event);
    }

    vm.toggleMenu = function($event) {
      MobileNavbarAnimations.toggleMenu($event);
    }

    vm.isAuthenticated = session.isAuthenticated;
    vm.empleado = session.obtenerEmpleado();
    vm.logout = session.logout;
  }

  var MobileNavbarAnimations = (function() {
    var currentTarget;
    var currentTargetHeight;
    var target;
    var targetHeight;
    var mobileModuleBaseHeight = 65;
    var mobileNavbarHidden;

    var animateMenu = function($event) {
      currentTarget = $event.currentTarget;
      target = $(currentTarget).children('.mobile-menu');
      calculateHeights();
      applyAnimation();
    }

    var calculateHeights = function() {
      currentTargetHeight = $(currentTarget).outerHeight();
      targetHeight = $(target).outerHeight();
    }

    var applyAnimation = function() {
      if( currentTargetHeight > mobileModuleBaseHeight ){
        collapseMenu();
      } else {
        expandMenu();
      }
    }

    var collapseMenu = function() {
      animate(mobileModuleBaseHeight, false, 0, -100);
    }

    var expandMenu = function() {
      var newMobileMenuHeight = currentTargetHeight + targetHeight;
      animate(newMobileMenuHeight, true, 1, 0);
    }

    var animate = function(newMobileMenuHeight, display, opacityValue, translateValue) {
      $(currentTarget).css({
        'max-height': newMobileMenuHeight
      })
      $(target).css({
        'opacity': opacityValue,
        'transform': 'translateY('+ translateValue +'%)'
      });
      $(target).css({
        'display': display ? 'block' : 'none'
      });
    }

    var toggleMenu = function($event) {
      currentTarget = $event.currentTarget;
      mobileNavbarHidden = $('.hamburguer').data('hidden');
      slideMenu();
      rotateHamburguer();
      $('.hamburguer').data('hidden', !mobileNavbarHidden);
    }

    var slideMenu = function() {
      $('.mobile-navbar').css({
        'display': mobileNavbarHidden ? 'block' : 'none',
        'transform': 'translateX('+ (mobileNavbarHidden ? '0':'-100') +'%)'
      });
    }

    var rotateHamburguer = function() {
      $('.hamburguer').css({
        'transform': 'rotateZ('+ (mobileNavbarHidden ? '90':'0') +'deg)'
      });
    }

    return {
      animate : animateMenu,
      toggleMenu : toggleMenu
    }
  })();

})();
