// app/empleado/empleado.controller.js

(function () {

  'use strict';

  angular
    .module('sagdApp.empleado')
    .controller('EmpleadoController', EmpleadoController);

  EmpleadoController.$inject = ['$http', '$auth', '$state', 'api'];

  function EmpleadoController($http, $auth, $state, api) {
    if(! $auth.isAuthenticated()){
      $state.go('login', {});
    }

    var vm = this;

    vm.empleados;
    vm.errores;

    vm.isAuthenticated = function () {
      return $auth.isAuthenticated();
    }

    vm.getEmpleados = function () {

      // This request will hit the index method in the AuthenticateController
      // on the Laravel side and will return the list of users
      $http.get(api.endpoint + '/empleado').success(function (empleados) {
        vm.empleados = empleados;
      }).error(function (error) {
        vm.errores = error;
      });
    }
  }

})();
