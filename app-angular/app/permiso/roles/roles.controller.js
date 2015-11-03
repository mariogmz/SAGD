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
    vm.permisosDisponibles = [];
    vm.selectModule = selectController;
    vm.selectRole = selectRole;
    vm.attach = attachToRole;
    vm.detach = detachFromRole;
    vm.able = isAble;
    vm.notAble = isntAble;

    activate();

    ////////////////

    function activate() {
      obtenerPermisosRoles().then(function(){
        obtenerPermisos();
      });
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

    function attachToRole(permiso) {
      vm.rolSeleccionado.permisos.push(permiso);
    }

    function detachFromRole(permiso) {
      for (var i = vm.rolSeleccionado.permisos.length - 1; i >= 0; i--) {
        var permisoRol = vm.rolSeleccionado.permisos[i];
        if (permisoRol.id === permiso.id) {
          vm.rolSeleccionado.permisos.splice(i,1);
          return;
        };
      };
    }

    function selectRole(role) {
      vm.rolSeleccionado = role;
      selectController(vm.controladorSeleccionado);
    }

    function selectController(controlador) {
      if (controlador === "") { return };
      if (vm.rolSeleccionado.length === 0) { return };

      vm.controladorSeleccionado = controlador;
      setPermisosDisponibles();
    }

    function setPermisosDisponibles(){
      vm.permisosDisponibles = [];
      for (var i = vm.permisos.length - 1; i >= 0; i--) {
        var permisoActual = vm.permisos[i];
        if (permisoActual.controlador === vm.controladorSeleccionado) {
          vm.permisosDisponibles.push(permisoActual);
        };
      };
    }

    function isAble(permiso) {
      for (var i = vm.rolSeleccionado.permisos.length - 1; i >= 0; i--) {
        var permisoRol = vm.rolSeleccionado.permisos[i];
        if (permisoRol.id === permiso.id) {
          return true;
        }
      };
      return false;
    }

    function isntAble(permiso) {
      return !isAble(permiso);
    }
  }
})();
