// app/empleado/roles/roles.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.empleado')
    .controller('empleadoRolesController', empleadoRolesController);

  empleadoRolesController.$inject = ['$auth', '$state', '$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function empleadoRolesController($auth, $state, $stateParams, api, pnotify) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.empleadoId = $stateParams.empleado;

    activate();

    ////////////////

    function activate() {
      obtenerEmpleado();
      obtenerRoles();
    }

    function obtenerEmpleado() {
      return api.get('/empleado/', vm.empleadoId).then(function(response) {
        vm.empleado = response.data.empleado;
      });
    }

    function obtenerRoles() {
      return api.get('/rol').then(function(response) {
        vm.roles = response.data;
      });
    }
  }
})();
