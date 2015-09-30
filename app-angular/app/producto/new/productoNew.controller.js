// app/producto/new/productoNew.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoNewController', ProductoNewController);

  ProductoNewController.$inject = ['$auth', '$state', 'api'];

  function ProductoNewController($auth, $state, api){
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

    function initialize(){
      obtenerMargenes().then(function (){
        console.log('Datos obtenidos correctamente');
      });
    }

    function goBack(){
      window.history.back();
    }
  }

})();
