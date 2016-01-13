// app/empleado/roles/roles.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.empleado')
    .controller('empleadoRolesController', empleadoRolesController);

  empleadoRolesController.$inject = ['$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function empleadoRolesController($stateParams, api, pnotify) {

    var vm = this;
    vm.empleadoId = $stateParams.empleado;
    vm.empleado = [];
    vm.roles = [];
    vm.rolesOriginal = [];
    vm.rolesEmpleado = [];
    vm.empleadoHas = empleadoHas;
    vm.empleadoDoesntHave = empleadoDoesntHave;
    vm.attach = attachLocal;
    vm.detach = detachLocal;
    vm.back = back;
    vm.toggleActives = toggleActives;

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
        vm.rolesOriginal = vm.roles;
      });
    }

    function obtenerRolesDeEmpleado(empleadoId) {
      return api.get('/empleado/' + empleadoId + '/roles').then(function(response) {
        vm.rolesEmpleado = response.data.roles;
      });
    }

    function attach(rol) {
      var endpoint = '/empleado/' + vm.empleadoId + '/roles/attach/' + rol;
      return api.post(endpoint);
    }

    function detach(rol) {
      var endpoint = '/empleado/' + vm.empleadoId + '/roles/detach/' + rol;
      return api.delete(endpoint);
    }

    function attachLocal(rol) {
      if (empleadoHas(rol)) {
        return
      }
      ;
      attach(rol.id).then(function() {
        vm.rolesEmpleado.push(rol);
      });
    }

    function detachLocal(rol) {
      if (empleadoDoesntHave(rol)) {
        return
      }
      ;
      detach(rol.id).then(function() {
        for (var i = vm.rolesEmpleado.length - 1; i >= 0; i--) {
          if (vm.rolesEmpleado[i].id === rol.id) {
            vm.rolesEmpleado.splice(i, 1);
            return;
          }
        }
      });
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

    function back() {
      window.history.back();
    }

    function toggleActives() {
      vm.roles = vm.active ? vm.rolesEmpleado : vm.rolesOriginal;
    }
  }
})();
