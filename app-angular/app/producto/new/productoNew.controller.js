// app/producto/new/productoNew.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoNewController', ProductoNewController);

  ProductoNewController.$inject = ['$auth', '$state'];

  function ProductoNewController($auth, $state){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    } else {
      $state.go('productoNew.step1');
    }

    var vm = this;
    vm.back = goBack;

    function goBack(){
      window.history.back();
    }
  }

})();
