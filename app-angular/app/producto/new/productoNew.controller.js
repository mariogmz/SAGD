// app/producto/new/productoNew.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoNewController', ProductoNewController);

  ProductoNewController.$inject = ['$state', 'api', 'pnotify', 'utils'];

  /* @ngInject */
  function ProductoNewController($state, api, pnotify, utils) {
    $state.go('productoNew.step1');

    var vm = this;
    vm.producto = {
      activo: false,
      remate: false,
      subclave: '',
      spiff: 0.0
    };
    vm.precio = {
      descuento: 0.0
    };
    vm.dimension = {};

    vm.back = goBack;
    vm.updateSubclave = updateSubclave;
    vm.updateClave = updateClave;
    vm.calcularPrecios = calcularPrecios;
    vm.calcular = calcular;
    vm.save = crearProducto;
    vm.setClass = utils.setClass;
    vm.obtenerFicha = obtenerFicha;

    initialize();

    /**
     * Resource calls on call order
     */
    function obtenerMarcas() {
      return api.get('/marca').then(function(response) {
        vm.marcas = response.data;
        console.log('Marcas obtenidas correctamente');
      });
    }

    function obtenerSubfamilias() {
      return api.get('/subfamilia').then(function(response) {
        vm.subfamilias = response.data;
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

    function initialize() {
      obtenerMarcas()
        .then(obtenerSubfamilias)
        .then(obtenerUnidades)
        .then(obtenerTiposDeGarantias)
        .then(obtenerMargenes)
        .then(function() {
          console.log('Datos obtenidos correctamente');
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

    function crearProducto() {
      vm.precio.descuento /= 100;
      return api.post('/producto', {
        producto: vm.producto,
        dimension: vm.dimension,
        precio: vm.precio
      }).then(function(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        $state.go('productoShow', {id: response.data.producto.id});
      }).catch(function(response) {
        pnotify.alertList(response.data.message, response.data.error, 'error');
      });
    }

    function calcularPrecios() {
      var params = [
        {key: 'precio', value: vm.precio.precio_1},
        {key: 'costo', value: vm.precio.costo},
        {key: 'margen_id', value: vm.producto.margen_id}
      ];
      return api.get('/calcular-precio', params)
        .then(function(response) {
          console.log(response.data.message);
          var descuento = vm.precio.descuento;
          vm.precio = response.data.resultado.precios;
          vm.precio.descuento = descuento;
          vm.utilidad = response.data.resultado.utilidades;

        }).catch(function(response) {
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function calcular() {
      if (vm.precio.costo && vm.precio.precio_1) {
        if (parseFloat(vm.precio.precio_1) <= parseFloat(vm.precio.costo)) {
          pnotify.alert('Advertencia', 'El precio 1 debe ser mayor al costo', 'warning');
        } else {
          calcularPrecios();
        }
      }
    }

    function obtenerFicha() {
      return api.get('/icecat/' + vm.producto.numero_parte + '/marca/' + vm.producto.marca_id)
        .then(function(response) {
          var ficha = response.data.ficha;
          vm.producto.descripcion = ficha.producto.descripcion;
          vm.producto.descripcion_corta = ficha.producto.descripcion_corta;
          if (ficha.producto.subfamilia_id) {
            vm.subfamilia = $.grep(vm.subfamilias, function(subfamilia) {
              return subfamilia.id === ficha.producto.subfamilia_id;
            })[0];

            vm.producto.subfamilia_id = ficha.producto.subfamilia_id;
            updateClave();
          }

          pnotify.alert('Ficha obtenida', response.data.message, 'info');
        }).catch(function(response) {
          pnotify.alert('Error', response.data.error, 'error');
        });
    }

    function goBack() {
      window.history.back();
    }
  }

})();
