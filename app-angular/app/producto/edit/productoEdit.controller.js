// app/producto/edit/productoEdit.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoEditController', ProductoEditController);

  ProductoEditController.$inject = ['$location', '$state', '$stateParams', 'utils', 'session',
    'Producto', 'Marca', 'Subfamilia', 'Unidad', 'TipoGarantia', 'Margen', 'Precio', 'Ficha', 'Icecat'];

  /* @ngInject */
  function ProductoEditController($location, $state, $stateParams, utils, session,
                                  Producto, Marca, Subfamilia, Unidad, TipoGarantia, Margen,
                                  Precio, Ficha, Icecat) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.empleado = session.obtenerEmpleado();
    vm.sortKeys = [
      {name: 'Proveedor', key: 'clave'},
      {name: 'Costo', key: 'costo'},
      {name: 'P1', key: 'precio_1'},
      {name: 'P2', key: 'precio_2'},
      {name: 'P3', key: 'precio_3'},
      {name: 'P4', key: 'precio_4'},
      {name: 'P5', key: 'precio_5'},
      {name: 'P6', key: 'precio_6'},
      {name: 'P7', key: 'precio_7'},
      {name: 'P8', key: 'precio_8'},
      {name: 'P9', key: 'precio_9'},
      {name: 'P10', key: 'precio_10'},
      {name: 'Dcto%', key: 'descuento'}
    ];
    vm.pretransferencias = {};

    vm.back = goBack;
    vm.guardarPretransferencias = guardarPretransferencias;
    vm.local = sucursalLocal;
    vm.obtenerFicha = obtenerFicha;
    vm.save = save;
    vm.setClass = utils.setClass;
    vm.sort = sort;
    vm.updateClave = updateClave;
    vm.updateSubclave = updateSubclave;

    ///////////////////////////////////

    initialize();

    function initialize() {
      utils.whichTab($location.hash() || 'datos-generales');
      obtenerProducto()
        .then(function() {
          obtenerMarcas();
          obtenerSubfamilias();
          obtenerUnidades();
          obtenerTiposDeGarantias();
          cargarFicha();
          obtenerExistencias();
          obtenerMovimientos();
        });

    }

    ////////////// API Calls  //////////////

    function obtenerProducto() {
      return Producto.show(vm.id)
        .then(function(producto) {
          vm.producto = producto || {id: null};
          console.log('Producto #' + vm.producto.id + ' obtenido.');
          $state.go('productoEdit.details');
          return producto;
        });
    }

    function obtenerMarcas() {
      return Marca.all()
        .then(function(marcas) {
          vm.marcas = marcas;
          vm.marca = vm.marcas.filter(function(element) {
            return vm.producto.marca_id == element.id;
          })[0];

          return marcas;
        });
    }

    function obtenerSubfamilias() {
      return Subfamilia.all()
        .then(function(subfamilias) {
          vm.subfamilias = subfamilias;
          vm.subfamilia = vm.subfamilias.filter(function(element) {
            return vm.producto.subfamilia_id == element.id;
          })[0];

          return subfamilias;
        });
    }

    function obtenerUnidades() {
      return Unidad.all()
        .then(function(unidades) {
          vm.unidades = unidades;
          return unidades;
        });
    }

    function obtenerTiposDeGarantias() {
      return TipoGarantia.all()
        .then(function(tiposGarantia) {
          vm.tiposGarantia = tiposGarantia;
          return tiposGarantia;
        });
    }

    function obtenerExistencias() {
      return Producto.existencias(vm.id)
        .then(function(existencias) {
          vm.producto_existencias = existencias;
          vm.pretransferencias = {};
          setupExistencias();
          console.log('Movimientos de producto obtenidos con éxito');

          return existencias;
        });
    }

    function obtenerMovimientos() {
      return Producto.movimientos(vm.id)
        .then(function(movimientos) {
          vm.producto_movimientos = movimientos;
          console.log('Movimientos de producto obtenidos con éxito');
          return movimientos;
        });
    }

    function guardarProducto() {
      return Producto.update(vm.id, vm.producto)
        .then(function(data) {
          if (data) {
            $state.go('productoShow', {id: vm.id});
          }
        });
    }

    function solicitarPretransferencia(data) {
      return Producto.pretransferir(vm.id, data)
        .then(function(data) {
          if (data) {
            obtenerExistencias();
          }

          return data;
        });
    }

    function cargarFicha() {
      return Ficha.completa(vm.producto.ficha.id)
        .then(function(ficha) {
          vm.ficha = ficha || {};
          return ficha;
        });
    }

    function obtenerFicha() {
      return Icecat.ficha(vm.producto.numero_parte, vm.producto.marca_id)
        .then(resultadosFicha);
    }

    ////////////// UI Behavior //////////////

    function updateSubclave() {
      if (vm.producto) {
        vm.producto.subclave = vm.producto.subclave || vm.producto.numero_parte || '';
        vm.producto.subclave = vm.producto.subclave.toUpperCase();
        updateClave();
      }
    }

    function updateClave() {
      var subfamilia = vm.subfamilia ? vm.subfamilia.clave : '';
      var familia = vm.subfamilia ? vm.subfamilia.familia.clave : '';
      var marca = vm.marca ? vm.marca.clave : '';

      vm.producto.clave = familia + subfamilia + marca + vm.producto.subclave;
      vm.producto.subfamilia_id = vm.subfamilia ? vm.subfamilia.id : null;
      vm.producto.marca_id = vm.marca ? vm.marca.id : null;
    }

    function save(formIsValid) {
      if (formIsValid) {
        vm.producto.precios.forEach(function(precio) {
          precio.descuento /= 100;
        });

        guardarProducto();
      }
    }

    function sucursalLocal(producto) {
      return vm.empleado.sucursal.nombre === producto.nombre;
    }

    function guardarPretransferencias() {
      vm.pretransferencias = $.map(vm.pretransferencias, function(value, index) {
        return [value];
      });

      vm.pretransferencias.push({sucursal_origen: vm.empleado.sucursal_id});
      vm.pretransferencias.push({empleado_id: vm.empleado.id});

      solicitarPretransferencia(vm.pretransferencias);
    }

    function setupExistencias() {
      for (var i = vm.producto_existencias.length - 1; i >= 0; i--) {
        var existencia = vm.producto_existencias[i];
        if (sucursalLocal(existencia)) {
          vm.pretransferenciaMaxima = existencia.cantidad;
        }

        var pretransferencia = {
          id: existencia.productos_sucursales_id,
          cantidad: existencia.cantidad,
          pretransferencia: 0
        };
        vm.pretransferencias[pretransferencia.id] = pretransferencia;
      }
    }

    function asignarResultado(resultado) {
      for (var attr in resultado.precios) {
        vm.producto.precios[index][attr] = resultado.precios[attr];
      }

      vm.utilidad = resultado.utilidades;
    }

    function resultadosFicha(ficha) {
      vm.producto.descripcion = ficha.producto.descripcion.substr(0, 299);
      vm.producto.descripcion_corta = ficha.producto.descripcion_corta.substr(0, 50);
      if (ficha.producto.subfamilia_id) {
        vm.subfamilia = $.grep(vm.subfamilias, function(subfamilia) {
          return subfamilia.id === ficha.producto.subfamilia_id;
        })[0];

        vm.producto.subfamilia_id = ficha.producto.subfamilia_id;
        updateClave();
      }

      return ficha;
    }

    //////// Utils /////////

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

    function goBack() {
      window.history.back();
    }
  }

})();
