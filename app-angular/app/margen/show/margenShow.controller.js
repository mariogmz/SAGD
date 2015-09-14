// app/margen/show/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenShowController', MargenShowController);

  MargenShowController.$inject = ['$auth', '$state', '$stateParams', '$http'];

  function MargenShowController($auth, $state, $stateParams, $http){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var baseUrl = 'http://api.sagd.app/api/v1/';
    var vm = this;
    vm.id = $stateParams.id;

    vm.getMargen = function (){
      $http.get(baseUrl + 'margen/' + vm.id).success(function (response){
        vm.margen = response.margen;
      }).error(function (response){
        vm.error = response.data;
      })
    };

    vm.getMargen();
  }

})();
