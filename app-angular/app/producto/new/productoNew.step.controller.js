// app/producto/new/productoNew.step.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoNewStepController', ProductoNewStepController);

  ProductoNewStepController.$inject = ['$state'];

  function ProductoNewStepController($state){

    var vm = this;

    vm.title = parent.title;
    vm.go = goToStep;

    function goToStep(step){
      $state.go('productoNew.step' + step);
    }
  }

})();
