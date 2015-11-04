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
    vm.empleado = [];
    vm.roles = [];
    vm.rolesEmpleado = [];
    vm.empleadoHas = empleadoHas;
    vm.empleadoDoesntHave = empleadoDoesntHave;
    vm.attach = attachLocal;
    vm.detach = detachLocal;

    activate();

    ////////////////

    function activate() {
      obtenerEmpleado().then(function() {
        obtenerRoles().then(function() {
          obtenerRolesDeEmpleado(vm.empleadoId);
        });
      });
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

    function obtenerRolesDeEmpleado(empleadoId) {
      return api.get('/empleado/'+empleadoId+'/roles').then(function(response) {
        vm.rolesEmpleado = response.data.roles;
      });
    }

    function attachLocal(rol) {
      vm.rolesEmpleado.push(rol);
    }

    function detachLocal(rol) {
      for (var i = vm.rolesEmpleado.length - 1; i >= 0; i--) {
        if (vm.rolesEmpleado[i].id === rol.id){
          vm.rolesEmpleado.splice(i,1);
          return;
        }
      };
    }

    function empleadoHas(rol) {
      for (var i = vm.rolesEmpleado.length - 1; i >= 0; i--) {
        if (vm.rolesEmpleado[i].id === rol.id) {
          return true;
        }
      }
      return false;
    }

    function empleadoDoesntHave(rol) {
      return !empleadoHas(rol);
    }
  }
})();
