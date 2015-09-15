// app/margen/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenEditController', MargenEditController);

  MargenEditController.$inject = ['$auth', '$state', '$http', '$stateParams'];

  function MargenEditController($auth, $state, $http, $stateParams){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var baseUrl = 'http://api.sagd.app/api/v1/';
    var vm = this;

    vm.get = function (){
      $http.get(baseUrl + 'margen/' + $stateParams.id).success(function (response){
        vm.margen = response.margen;
        vm.error = false;
      }).error(function (response){
        vm.error = response;
      })
    };

    vm.save = function (){
      $http.put(baseUrl + 'margen/' + vm.margen.id, vm.margen).success(function (response){
        vm.message = response.message;
        vm.error = false;
      }).error(function (response){
        debugger;
        vm.error = response;
      })
    };

    vm.clean = function(){
      vm.message = null;
      vm.error = null;
    };

    vm.get();
  }

})();
