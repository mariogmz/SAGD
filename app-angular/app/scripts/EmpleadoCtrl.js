// scripts/empleadoController.js

(function () {

  'use strict';

  angular
    .module('sagdApp')
    .controller('EmpleadoController', EmpleadoController);

  function EmpleadoController($http) {

    var vm = this;

    vm.empleados;
    vm.errores;

    vm.getUsers = function () {

      // This request will hit the index method in the AuthenticateController
      // on the Laravel side and will return the list of users
      $http.get('api/authenticate').success(function (empleados) {
        vm.empleados = empleados;
      }).error(function (error) {
        vm.errores = error;
      });
    }
  }

})();
