// app/producto/edit/productoEdit.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoEditController', ProductoEditController);

  ProductoEditController.$inject = ['$state', '$stateParams', 'api', 'pnotify', 'utils', 'session'];

  function ProductoEditController($state, $stateParams, api, pnotify, utils, session) {

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

    vm.updateClave = updateClave;
    vm.updateSubclave = updateSubclave;
    vm.save = save;
    vm.calcularPrecios = calcularPrecios;
    vm.calcularPreciosMargen = calcularPreciosMargen;
    vm.setClass = utils.setClass;
    vm.local = sucursalLocal;
    vm.guardarPretransferencias = guardarPretransferencias;
    vm.sort = sort;
    vm.back = goBack;

    ///////////////////////////////////

    initialize();

    function initialize() {
      obtenerProducto()
        .then(function() {
          obtenerMarcas();
          obtenerSubfamilias();
          obtenerUnidades();
          obtenerTiposDeGarantias();
          obtenerMargenes();
          obtenerExistencias();
        });

    }

    function obtenerProducto() {
      return api.get('/producto/', vm.id)
        .then(function(response) {
          vm.producto = response.data.producto;
          vm.subfamilia = vm.producto.subfamilia;
          vm.producto.precios = response.data.precios_proveedor;
          vm.producto.revisado = true;
          vm.producto.precios.forEach(function(precio) {
            vm.producto.revisado = vm.producto.revisado && precio.revisado;
            precio.descuento *= 100;
          });

          console.log('Producto #' + vm.id + ' obtenido.');
          $state.go('productoEdit.details');
          return response.data;
        })
        .catch(function(response) {
          vm.error = response.data;
          return response.data;
        });
    }

    function obtenerMarcas() {
      return api.get('/marca').then(function(response) {
        vm.marcas = response.data;
        vm.marca = vm.marcas.filter(function(element) {
          return vm.producto.marca_id == element.id;
        })[0];

        console.log('Marcas obtenidas correctamente');
      });
    }

    function obtenerSubfamilias() {
      return api.get('/subfamilia').then(function(response) {
        vm.subfamilias = response.data;
        vm.subfamilia = vm.subfamilias.filter(function(element) {
          return vm.producto.subfamilia_id == element.id;
        })[0];

        console.log('Subfamilias obtenidas');
      });
    }

    function obtenerUnidades() {
      return api.get('/unidad').then(function(response) {
        vm.unidades = response.data;
        console.log('Unidades obtenidas correctamente');
      });
    }

    function obtenerTiposDeGarantias() {
      return api.get('/tipo-garantia').then(function(response) {
        vm.tiposGarantia = response.data;
        console.log('Tipos de garantía obtenidos correctamente');
      });
    }

    function obtenerMargenes() {
      return api.get('/margen').then(function(response) {
        vm.margenes = response.data;
        console.log('Margenes obtenidos correctamente');
      });
    }

    function obtenerExistencias() {
      return api.get('/producto/' + vm.id + '/existencias').then(function(response) {
        vm.producto_existencias = response.data.productos;

        for (var i = vm.producto_existencias.length - 1; i >= 0; i--) {
          var existencia = vm.producto_existencias[i];
          var pretransferencia = {
            id: existencia.productos_sucursales_id,
            cantidad: existencia.cantidad,
            pretransferencia: 0
          };
          vm.pretransferencias[pretransferencia.id] = pretransferencia;
        };
      });
    }

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
        guardarProducto();
      }
    }

    function guardarProducto() {
      vm.producto.precios.forEach(function(precio) {
        precio.descuento /= 100;
      });

      return api.put('/producto/', vm.id, vm.producto)
        .then(function(response) {
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          $state.go('productoShow', {id: vm.id});
          return response;
        })
        .catch(function(response) {
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar el producto', vm.error.error, 'error');
          return response;
        });
    }

    function calcularPrecios(index) {
      var params = [
        {key: 'precio', value: vm.producto.precios[index].precio_1},
        {key: 'costo', value: vm.producto.precios[index].costo},
        {key: 'margen_id', value: vm.producto.margen_id},
        {key: 'externo', value: vm.producto.precios[index].externo}
      ];
      return api.get('/calcular-precio', params)
        .then(function(response) {
          console.log(response.data.message);
          for (var attr in response.data.resultado.precios) {
            vm.producto.precios[index][attr] = response.data.resultado.precios[attr];
          }

          vm.utilidad = response.data.resultado.utilidades;

        }).catch(function(response) {
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function calcularPreciosMargen() {
      var cantidadProveedores = vm.producto.precios.length;
      for (var i = 0; i < cantidadProveedores; i++) {
        calcularPrecios(i);
      }
    }

    function sucursalLocal(producto) {
      return vm.empleado.sucursal.nombre === producto.nombre;
    }

    function guardarPretransferencias() {
      vm.pretransferencias = $.map(vm.pretransferencias, function(value, index) {
        return [value];
      });

      apiPretransferencias(vm.pretransferencias).then(function(response) {
        console.log('Pretransferencia guardada');
        pnotify.alert('Exito', response.data.message, 'success');
      }).catch(function(response) {
        pnotify.alertList(response.data.message, response.data.error, 'error');
      });
    }

    function apiPretransferencias(data) {
      return api.post('/producto/' + vm.id + '/existencias/pretransferir', data);
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
