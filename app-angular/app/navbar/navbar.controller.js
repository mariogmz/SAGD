// app/navbar/navbar.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.navbar')
    .controller('NavbarController', NavbarController)
    .directive('navBar', function() {
      return {
        bindToController: true,
        controller: NavbarController,
        controllerAs: 'vm',
        restrict: 'A',
        templateUrl: 'app/navbar/navbar.html'
      };
    });

  NavbarController.$inject = ['session', 'state'];

  function NavbarController(session, state) {
    var vm = this;
    vm.modules = [
      {
        name: 'Inicio',
        state: 'home',
        active: false
      }, {
        name: 'Productos',
        state: 'productoIndex',
        active: false,
        submodules: [
          {
            name: 'Consultar',
            state: 'productoIndex'
          }, {
            name: 'Características',
            state: 'producto.caracteristica',
            actions: [
              {
                name: 'Marcas',
                state: 'marcaIndex'
              }, {
                name: 'Garantías',
                state: 'garantiaIndex'
              }, {
                name: 'Unidades',
                state: 'unidadIndex'
              }, {
                name: 'Familias',
                state: 'familiaIndex'
              }, {
                name: 'Subfamilias',
                state: 'subfamiliaIndex'
              }
            ]
          },
          {
            name: 'Revisar precios',
            state: 'revisarPreciosIndex'
          }, {
            name: 'Márgenes',
            state: 'margenIndex'
          }, {
            name: 'Inventario',
            state: 'inventario',
            actions: [
              {
                name: 'Existencias',
                state: 'producto.existencia'
              }, {
                name: 'Entradas',
                state: 'entradaIndex'
              }, {
                name: 'Salidas',
                state: 'salidaIndex'
              }, {
                name: 'Transferencias',
                state: 'transferenciaIndex'
              }, {
                name: 'Por Transferir',
                state: 'pretransferenciaIndex'
              }, {
                name: 'Apartados',
                state: 'apartadoIndex'
              }, {
                name: 'Resurtir',
                state: 'resurtir'
              }, {
                name: 'Historial de movimientos',
                state: 'producto.movimiento'
              }
            ]
          }
        ]
      }, {
        name: 'Ventas',
        state: 'venta',
        active: false,
        submodules: [
          {
            name: 'Vender',
            state: 'venta.vender'
          }, {
            name: 'Consultar',
            state: 'venta'
          }, {
            name: 'Garantías',
            state: 'venta.garantia'
          }, {
            name: 'Reportes',
            state: 'venta.reporte',
            actions: [
              {
                name: 'Sucursales',
                state: 'venta.reporte.sucursal'
              }, {
                name: 'Utilidad',
                state: 'venta.reporte.utilidad'
              }, {
                name: 'Metas',
                state: 'venta.reporte.meta'
              }
            ]
          }, {
            name: 'Configuración',
            state: 'venta.configuracion',
            actions: [
              {
                name: 'Tipos de venta',
                state: 'venta.configuracion.tipo'
              }, {
                name: 'Estados de venta',
                state: 'venta.configuracion.estado'
              }, {
                name: 'Tipos de partida',
                state: 'venta.configuracion.partida'
              }, {
                name: 'Métodos de pago',
                state: 'venta.configuracion.metodo'
              }
            ]
          }
        ]
      }, {
        name: 'Clientes',
        state: 'clienteIndex',
        active: false,
        submodules: [
          {
            name: 'Consultar',
            state: 'clienteIndex'
          }, {
            name: 'Página Web Distribuidores',
            state: 'cliente.pagina'
          }
        ]
      }, {
        name: 'Sucursales',
        state: 'sucursalIndex',
        active: false,
        submodules: [
          {
            name: 'Consultar',
            state: 'sucursalIndex'
          }, {
            name: 'Proveedores',
            state: 'proveedorIndex'
          }, {
            name: 'Gastos',
            state: 'sucursal.gastos'
          }, {
            name: 'Configuración',
            state: 'sucursal.configuracion'
          }
        ]
      }, {
        name: 'Soporte Técnico',
        state: 'soporte',
        active: false,
        submodules: [
          {
            name: 'Servicio',
            state: 'soporte'
          }, {
            name: 'RMA',
            state: 'soporte.rma'
          }, {
            name: 'Configuración',
            state: 'soporte.configuracion',
            actions: [
              {
                name: 'Estados de servicio',
                state: 'soporte.configuracion.estadoServicio'
              }, {
                name: 'Estados de RMA',
                state: 'soporte.configuracion.estadoRma'
              }, {
                name: 'Tiempos de RMA',
                state: 'soporte.configuracion.tiempoRma'
              }
            ]
          }
        ]
      }, {
        name: 'Empleados',
        state: 'empleadoIndex',
        active: false,
        submodules: [
          {
            name: 'Consultar',
            state: 'empleadoIndex'
          }, {
            name: 'Roles',
            state: 'rolIndex'
          }, {
            name: 'Permisos',
            state: 'permisoIndex',
            actions: [
              {
                name: 'Individuales',
                state: 'permisoIndividuales'
              }, {
                name: 'Roles',
                state: 'permisoRoles'
              }
            ]
          }
        ]
      }, {
        name: 'Cajas y Cortes',
        state: 'cajasCortes',
        active: false,
        submodules: [
          {
            name: 'Cajas',
            state: 'cajas'
          }, {
            name: 'Corte de Caja',
            state: 'corte',
            actions: [
              {
                name: 'Consultar',
                state: 'corte'
              }, {
                name: 'Realizar corte',
                state: 'corte.nuevo'
              }, {
                name: 'Configuración',
                state: 'corte.configuracion'
              }
            ]
          }
        ]
      }, {
        name: 'Paqueterías',
        state: 'paqueteria',
        active: false,
        submodules: [
          {
            name: 'Consultar',
            state: 'paqueteria'
          }, {
            name: 'Coberturas',
            state: 'paqueteria.cobertura'
          }, {
            name: 'Guías',
            state: 'paqueteria.guia'
          }, {
            name: 'Zonas',
            state: 'paqueteria.zona'
          }
        ]
      }, {
        name: 'Facturación',
        state: 'facturacion',
        active: false,
        submodules: [
          {
            name: 'Facturas',
            state: 'facturacion',
            actions: [
              {
                name: 'Consultar',
                state: 'facturacion'
              }, {
                name: 'Facturar ventas',
                state: 'facturacion.venta'
              }, {
                name: 'Reportes',
                state: 'facturacion.reporte'
              }
            ]
          }, {
            name: 'Notas de crédito',
            state: 'facturacion.notacredito'
          }, {
            name: 'Configuración',
            state: 'facturacion.configuracion',
            actions: [
              {
                name: 'Razones sociales emisores',
                state: 'facturacion.configuracion.rse'
              }, {
                name: 'Razones sociales receptores',
                state: 'facturacion.configuracion.rsr'
              }, {
                name: 'Estados de facturas',
                state: 'facturacion.configuracion.estado'
              }
            ]
          }
        ]
      }, {
        name: 'Configuración',
        state: 'configuracion',
        active: false,
        submodules: [
          {
            name: 'Sucursales',
            state: 'configuracion.sucursal'
          }, {
            name: 'Logs',
            state: 'logsIndex'
          }, {
            name: 'PM',
            state: 'configuracion.pm'
          }, {
            name: 'Tipo de Cambio',
            state: 'configuracion.tipocambio'
          }, {
            name: 'Icecat',
            state: 'icecatIndex'
          }
        ]
      }
    ];

    var searchParent = function(currentState) {
      for (var i = 0; i < vm.modules.length; i++) {
        if (vm.modules[i].state === currentState) {
          return i;
        } else {

          if (vm.modules[i].submodules) {
            for (var e = 0; e < vm.modules[i].submodules.length; e++) {
              if (vm.modules[i].submodules[e].state === currentState) {
                return i;
              } else {

                if (vm.modules[i].submodules[e].actions) {
                  for (var x = 0; x < vm.modules[i].submodules[e].actions.length; x++) {
                    if (vm.modules[i].submodules[e].actions[x].state === currentState) {
                      return i;
                    }
                  }
                }

              }
            }
          }

        }
      }

      return null;
    };

    vm.setActiveState = function() {
      var current_state = state.current_state();
      var index = searchParent(current_state);
      if (index) {
        vm.modules[index].active = true;
      }
    };

    vm.setActiveState();

    vm.clicked = function($event) {
      $('li.module-list-item').each(function() {
        $(this).removeClass('active');
      });

      $($event.currentTarget).addClass('active');
    };

    vm.expandMenu = function($event) {
      MobileNavbarAnimations.animate($event);
    };

    vm.toggleMenu = function($event) {
      MobileNavbarAnimations.toggleMenu($event);
    };

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
    };

    var calculateHeights = function() {
      currentTargetHeight = $(currentTarget).outerHeight();
      targetHeight = $(target).outerHeight();
    };

    var applyAnimation = function() {
      if (currentTargetHeight > mobileModuleBaseHeight) {
        collapseMenu();
      } else {
        expandMenu();
      }
    };

    var collapseMenu = function() {
      animate(mobileModuleBaseHeight, false, 0, -100);
    };

    var expandMenu = function() {
      var newMobileMenuHeight = currentTargetHeight + targetHeight;
      animate(newMobileMenuHeight, true, 1, 0);
    };

    var animate = function(newMobileMenuHeight, display, opacityValue, translateValue) {
      $(currentTarget).css({
        'max-height': newMobileMenuHeight
      });
      $(target).css({
        opacity: opacityValue,
        transform: 'translateY(' + translateValue + '%)'
      });
      $(target).css({
        display: display ? 'block' : 'none'
      });
    };

    var toggleMenu = function($event) {
      currentTarget = $event.currentTarget;
      mobileNavbarHidden = $('.hamburguer').data('hidden');
      slideMenu();
      rotateHamburguer();
      $('.hamburguer').data('hidden', !mobileNavbarHidden);
    };

    var slideMenu = function() {
      $('.mobile-navbar').css({
        display: mobileNavbarHidden ? 'block' : 'none',
        transform: 'translateX(' + (mobileNavbarHidden ? '0' : '-100') + '%)'
      });
    };

    var rotateHamburguer = function() {
      $('.hamburguer').css({
        transition: 'all 0.5s ease-in-out',
        transform: 'rotateZ(' + (mobileNavbarHidden ? '90' : '0') + 'deg)'
      });
    };

    return {
      animate: animateMenu,
      toggleMenu: toggleMenu
    };
  })();

})();
