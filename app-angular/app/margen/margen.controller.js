// app/margen/margen.controller.js

(function () {

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenController', MargenController);

  MargenController.$inject = ['$auth', '$state'];

  function MargenController($auth, $state) {
    if(! $auth.isAuthenticated()){
      $state.go('login',{});
    }
  }

})();
