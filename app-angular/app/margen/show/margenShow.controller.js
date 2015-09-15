// app/margen/show/margen.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenShowController', MargenShowController);

  MargenShowController.$inject = ['$auth', '$state', '$stateParams', '$http', 'api'];

  function MargenShowController($auth, $state, $stateParams, $http, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var baseUrl = api.endpoint + '/';
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
