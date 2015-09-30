// app/producto/new/productoNew.step.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoNewStepController', ProductoNewStepController);

  ProductoNewStepController.$inject = ['$state', '$scope'];

  function ProductoNewStepController($state, $scope){

    var vm = this;
    var parent = $scope.parentVm;

    vm.go = goToStep;
    vm.updateSubclave = updateSubclave;
    vm.updateClave = updateClave;

    function goToStep(step){
      $state.go('productoNew.step' + step);
    }

    function updateSubclave(){
      if (parent.producto) {
        vm.subclave = vm.subclave || parent.producto.numero_parte;
        vm.subclave = vm.subclave.toUpperCase()
        parent.producto.subclave = vm.subclave;
        updateClave();
      }
    }

    function updateClave(){
      var subfamilia = vm.subfamilia ? vm.subfamilia.clave : '';
      var familia = vm.subfamilia ? vm.subfamilia.familia.clave : '';
      var marca = vm.marca ? vm.marca.clave : '';
      var subclave = vm.subclave || '';

      vm.clave = familia + subfamilia + marca + subclave;

      parent.producto.clave = vm.clave;
      parent.producto.subfamilia_id = vm.subfamilia ? vm.subfamilia.id : null;
      parent.producto.marca = vm.marca ? vm.marca.id : null;

    }
  }

})();
