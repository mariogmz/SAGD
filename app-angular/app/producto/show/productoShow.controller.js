// app/producto/show/producto.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoShowController', ProductoShowController);

  ProductoShowController.$inject = ['$location', '$state', '$stateParams', 'api', 'pnotify', 'session', 'utils'];

  /* @ngInject */
  function ProductoShowController($location, $state, $stateParams, api, pnotify, session, utils) {

    var vm = this;
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
      {name: 'Descuento', key: 'descuento'}
    ];
    vm.empleado = session.obtenerEmpleado();
    vm.id = $stateParams.id;
    vm.back = goBack;
    vm.sort = sort;

    initialize();

    function initialize() {
      utils.whichTab($location.hash() || 'datos-generales');
      obtenerProducto().then(function(response) {

        console.log('Producto obtenido correctamente');
        vm.producto = response.data.producto;
        if (!vm.producto.margen) {
          vm.producto.margen = {nombre: 'Libre'};
        }

        vm.precios = response.data.precios_proveedor;
        vm.producto.revisado = true;
        vm.precios.forEach(function(precio) {
          vm.producto.revisado = vm.producto.revisado && precio.revisado;
        });

        return response;
      }).then(function() {
        obtenerExistencias().then(function(response) {
          console.log('Existencias de producto obtenidas con exito');
          vm.producto_existencias = response.data.productos;
          return response;
        });
      }).then(function() {
        obtenerMovimientos().then(function(response) {
          console.log('Movimientos de producto obtenidos con exito');
          vm.producto_movimientos = response.data.productos;
          return response;
        });
      }).then(function() {
        cargarFicha().then(function(response) {
          console.log(response.data.message);
          vm.ficha = response.data.ficha;
        });
      }).then(function() {
        $state.go('productoShow.details');
      }).catch(error);
    }

    function obtenerProducto() {
      return api.get('/producto/', vm.id);
    }

    function obtenerExistencias() {
      return api.get('/producto/' + vm.id + '/existencias');
    }

    function obtenerMovimientos() {
      return api.get('/producto/' + vm.id + '/movimientos/sucursal/' + vm.empleado.sucursal_id);
    }

    function cargarFicha() {
      return api.get('/ficha/completa/', vm.producto.ficha.id);
    }

    function error(response) {
      console.log('Hubo un error con la peticion.');
      pnotify.alert('Error', response.data.message, 'error');
    }

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

    function goBack() {
      window.history.back();
    }
  }
})();
