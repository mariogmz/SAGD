// app/producto/new/step1/productoNew.step1.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoNewStep1Controller', ProductoNewStep1Controller);

  ProductoNewStep1Controller.$inject = ['$state'];

  function ProductoNewStep1Controller($state){

    var vm = this;
    this.nextStep = function (){
      $state.go('productoNew.step2');
    }
  }

})();
