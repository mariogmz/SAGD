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
    vm.producto = {
      activo: true,
      remate: false
    };
    vm.precio = {};
    vm.dimension = {};

    vm.back = goBack;
    vm.updateSubclave = updateSubclave;
    vm.updateClave = updateClave;
    vm.save = crearProducto;

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
      return api.get('/subfamilia').then(function (response){
        vm.subfamilias = response.data;
        console.log('Subfamilias obtenidas');
      });
    }

    function obtenerUnidades(){
      return api.get('/unidad').then(function (response){
        vm.unidades = response.data;
        console.log('Unidades obtenidas correctamente');
      });
    }

    function obtenerTiposDeGarantias(){
      return api.get('/tipo-garantia').then(function (response){
        vm.tiposGarantia = response.data;
        console.log('Tipos de garantía obtenidos correctamente');
      });
    }

    function obtenerMargenes(){
      return api.get('/margen').then(function (response){
        vm.margenes = response.data;
        console.log('Margenes obtenidos correctamente');
      });
    }

    function initialize(){
      obtenerMarcas()
      .then(obtenerSubfamilias)
      .then(obtenerUnidades)
      .then(obtenerTiposDeGarantias)
      .then(obtenerMargenes)
      .then(function(){
        console.log('Datos obtenidos correctamente');
      });
    }

    function updateSubclave(){
      if (vm.producto) {
        vm.producto.subclave = vm.producto.subclave || vm.producto.numero_parte || '';
        vm.producto.subclave = vm.producto.subclave.toUpperCase();
        updateClave();
      }
    }

    function updateClave(){
      var subfamilia = vm.subfamilia ? vm.subfamilia.clave : '';
      var familia = vm.subfamilia ? vm.subfamilia.familia.clave : '';
      var marca = vm.marca ? vm.marca.clave : '';

      vm.producto.clave = familia + subfamilia + marca + vm.producto.subclave;
      vm.producto.subfamilia_id = vm.subfamilia ? vm.subfamilia.id : null;
      vm.producto.marca_id = vm.marca ? vm.marca.id : null;
    }

    function crearProducto(){
      console.log({
        producto: vm.producto,
        dimension: vm.dimension,
        precio: vm.precio
      });
      return api.post('/producto', {
        producto: vm.producto,
        dimension: vm.dimension,
        precio: vm.precio
      }).then(function (response){
        pnotify.alert('¡Exito!', response.data.message, 'success');
        $state.go('productoShow', {id: response.data.producto.id});
      }).catch(function (response){
        pnotify.alertList(response.data.message, response.data.error, 'error');
      });
    }

    function goBack(){
      window.history.back();
    }
  }

})();
