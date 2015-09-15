// app/margen/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenEditController', MargenEditController);

  MargenEditController.$inject = ['$auth', '$state', '$http', '$stateParams', 'api'];

  function MargenEditController($auth, $state, $http, $stateParams, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var baseUrl = api.endpoint + '/';
    var vm = this;

    vm.getMargen = function (){
      $http.get(baseUrl + 'margen/' + $stateParams.id).success(function (response){
        vm.margen = response.margen;
        vm.error = false;
      }).error(function (response){
        vm.message = response.message;
        vm.error = response.error;
      })
    };

    vm.save = function(){
      $http.put(baseUrl + 'margen/' + vm.margen.id, vm.margen).success(function(response){
        vm.message = response.message;
        vm.error = response.error;
      }).error(function(response){
        vm.message = response.message;
        vm.error = response.error;
      })
    };

    vm.delete = function(){
      $http.put(baseUrl + 'margen/' + vm.margen.id, vm.margen).success(function(response){
        vm.message = response.message;
        vm.error = response.error;
      }).error(function(response){
        vm.message = response.message;
        vm.error = response.error;
      })
    };

    vm.getMargen();
  }

})();
