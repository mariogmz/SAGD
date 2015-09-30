// app/producto/new/productoNew.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoNewController', ProductoNewController);

  ProductoNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function ProductoNewController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    } else {
      $state.go('productoNew.step1');
    }

    var vm = this;
    vm.producto = {};
    vm.precio = {};
    vm.dimension = {};

    vm.back = goBack;
    vm.updateSubclave = updateSubclave;
    vm.updateClave = updateClave;
    vm.save = crearPrecio;

    initialize();

    /**
     * Resource calls on call order
     */
    function obtenerMarcas(){
      return api.get('/marca').then(function (response){
        vm.marcas = response.data;
        console.log('Marcas obtenidas correctamente');
      });
    }

    function obtenerSubfamilias(){
      return obtenerMarcas().then(function (){
        return api.get('/subfamilia').then(function (response){
          vm.subfamilias = response.data;
          console.log('Subfamilias obtenidas');

        });
      });
    }

    function obtenerUnidades(){
      return obtenerSubfamilias().then(function (){
        return api.get('/unidad').then(function (response){
          vm.unidades = response.data;
          console.log('Unidades obtenidas correctamente');

        });
      });
    }

    function obtenerTiposDeGarantias(){
      return obtenerUnidades().then(function (){
        return api.get('/tipo-garantia').then(function (response){
          vm.tiposGarantia = response.data;
          console.log('Tipos de garantía obtenidos correctamente');
        });
      });
    }

    function obtenerMargenes(){
      return obtenerTiposDeGarantias().then(function (){
        return api.get('/margen').then(function (response){
          vm.margenes = response.data;
          console.log('Margenes obtenidos correctamente');
        })
      });
    }

    function obtenerProveedoresConSucursales(){
      return api.get('/proveedor')
    }

    function updateSubclave(){
      if (vm.producto) {
        vm.producto.subclave = vm.producto.subclave || vm.producto.numero_parte;
        vm.producto.subclave = vm.producto.subclave.toUpperCase();
        updateClave();
      }
    }

    function updateClave(){
      var subfamilia = vm.subfamilia ? vm.subfamilia.clave : '';
      var familia = vm.subfamilia ? vm.subfamilia.familia.clave : '';
      var marca = vm.marca ? vm.marca.clave : '';

      vm.producto.clave = familia + subfamilia + marca + (vm.producto.subclave || '');
      vm.producto.subfamilia_id = vm.subfamilia ? vm.subfamilia.id : null;
      vm.producto.marca_id = vm.marca ? vm.marca.id : null;
    }

    function initialize(){
      obtenerMargenes().then(function (){
        console.log('Datos obtenidos correctamente');
      });
    }

    function crearProducto(){
      return api.post('/producto', vm.producto)
        .then(function (response){
          vm.producto = response.data.producto;
          console.log('Producto creado correctamente, id: ' + vm.producto.id);
        }).catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function crearDimension(){
      return crearProducto().then(function (){
        return api.post('/dimension', vm.dimension)
          .then(function (response){
            vm.dimension = response.data.dimension;
            console.log('Dimension creada correctamente, id: ' + vm.dimension.id);
          })
          .catch(function (response){
            pnotify.alertList(response.data.message, response.data.error, 'error');
          });
      });
    }

    function crearProductoSucursal(){
      return crearDimension().then(function (){

      });
    }

    function crearPrecio(){
      return crearProductoSucursal().then(function(){

      });
    }

    function goBack(){
      window.history.back();
    }
  }

})();
