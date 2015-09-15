// app/margen/index/margenIndex.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.margen')
    .controller('margenIndexController', MargenIndexController);

  MargenIndexController.$inject = ['$auth', '$state', '$http', 'api'];

  function MargenIndexController($auth, $state, $http, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;

    vm.obtenerMargen = function (){
      $http.get(api.endpoint + '/margen').
        then(function (response){
          vm.margenes = response.data;
        }, function (response){
          vm.errors = response.data;
        });
    };

    vm.obtenerMargen();
  }

})();
