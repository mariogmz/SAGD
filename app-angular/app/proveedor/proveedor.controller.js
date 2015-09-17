// app/proveedor/proveedor.controller.js

(function () {
  'use strict';

  angular
      .module('sagdApp.proveedor')
      .controller("proveedorController", ProveedorController);

  ProveedorController.$inject = ['$auth', '$state', '$http'];

  function ProveedorController($auth, $state, $http) {
    if(! $auth.isAuthenticated()){
      $state.go('login', {});
    }
    var vm = this;

    vm.itemsPerPage = 5;

    vm.obtenerProveedores = function (){
      $http.get('http://api.sagd.app/api/v1/proveedor?page=1').
          then(function (response){
            vm.proveedores = response.data;
          }, function (response){
            vm.errors = response;
          });
    };
    vm.obtenerProveedores();

    /*
    function($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    });
    */

    vm.pageChanged = function(newPage) {
        getResultsPage(newPage);
    };

    function getResultsPage(pageNumber) {
          // this is just an example, in reality this stuff should be in a service
          $http.get('http://api.sagd.app/api/v1/proveedor?page=' + pageNumber)
              .then(function(result) {
                  vm.proveedores = result.data.Items;
                  vm.totalItems = result.data.Count
              });
    }

  }



})();
