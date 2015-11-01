// app/permiso/roles/roles.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.permiso')
    .controller('permisoRolesController', permisoRolesController);

  permisoRolesController.$inject = ['$auth', '$state', 'api', 'pnotify', 'modal'];

  /* @ngInject */
  function permisoRolesController($auth, $state, api, pnotify, modal) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.controladorSeleccionado = "";
    vm.rolSeleccionado = [];
    vm.roles = [];
    vm.permisos = [];
    vm.acciones = [];
    vm.selectModule = selectController;
    vm.selectRole = selectRole;

    activate();

    ////////////////

    function activate() {
      obtenerPermisos();
      return obtenerPermisosRoles();
    }

    function obtenerPermisosRoles() {
      return api.get('/permiso/generales').then(function(response){
        vm.roles = response.data;
        return response;
      });
    }

    function obtenerPermisos() {
      return api.get('/permiso').then(function(response){
        vm.permisos = response.data;
        return response;
      })
    }

    function selectController(controlador) {
      vm.controladorSeleccionado = controlador;
      vm.acciones = [];
      for (var i = vm.permisos.length - 1; i >= 0; i--) {
        var permisoActual = vm.permisos[i];
        if (permisoActual.controlador === vm.controladorSeleccionado) {
          vm.acciones.push({'nombre': permisoActual.accion});
        };
      };
    }

    function selectRole(role) {
      vm.rolSeleccionado = role;
    }
  }
})();
