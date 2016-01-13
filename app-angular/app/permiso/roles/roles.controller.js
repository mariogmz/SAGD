// app/permiso/roles/roles.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.permiso')
    .controller('permisoRolesController', permisoRolesController);

  permisoRolesController.$inject = ['api', 'pnotify', 'modal'];

  /* @ngInject */
  function permisoRolesController(api, pnotify, modal) {

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
      obtenerPermisosRoles().then(function() {
        obtenerPermisos();
      });
    }

    function obtenerPermisosRoles() {
      return api.get('/permiso/generales').then(function(response) {
        vm.roles = response.data;
        return response;
      });
    }

    function obtenerPermisos() {
      return api.get('/permiso').then(function(response) {
        vm.permisos = response.data;
        return response;
      })
    }

    function attach(rolId, permisoId) {
      var endpoint = '/rol/attach/' + rolId + '/' + permisoId;
      return api.post(endpoint);
    }

    function detach(rolId, permisoId) {
      var endpoint = '/rol/detach/' + rolId + '/' + permisoId;
      return api.delete(endpoint);
    }

    function attachToRole(permiso) {
      if (isAble(permiso)) {
        return
      }
      ;
      attach(vm.rolSeleccionado.id, permiso.id).then(function(repsonse) {
        vm.rolSeleccionado.permisos.push(permiso);
      });
    }

    function detachFromRole(permiso) {
      if (isntAble(permiso)) {
        return
      }
      ;
      detach(vm.rolSeleccionado.id, permiso.id).then(function(response) {
        for (var i = vm.rolSeleccionado.permisos.length - 1; i >= 0; i--) {
          var permisoRol = vm.rolSeleccionado.permisos[i];
          if (permisoRol.id === permiso.id) {
            vm.rolSeleccionado.permisos.splice(i, 1);
            return;
          }
        }
      });
    }

    function selectRole(role) {
      vm.rolSeleccionado = role;
      selectController(vm.controladorSeleccionado);
    }

    function selectController(controlador) {
      if (controlador === "") {
        return
      }
      ;
      if (vm.rolSeleccionado.length === 0) {
        return
      }
      ;

      vm.controladorSeleccionado = controlador;
      setPermisosDisponibles();
    }

    function setPermisosDisponibles() {
      vm.permisosDisponibles = [];
      for (var i = vm.permisos.length - 1; i >= 0; i--) {
        var permisoActual = vm.permisos[i];
        if (permisoActual.controlador === vm.controladorSeleccionado) {
          vm.permisosDisponibles.push(permisoActual);
        }
        ;
      }
      ;
    }

    function isAble(permiso) {
      for (var i = vm.rolSeleccionado.permisos.length - 1; i >= 0; i--) {
        var permisoRol = vm.rolSeleccionado.permisos[i];
        if (permisoRol.id === permiso.id) {
          return true;
        }
      }
      ;
      return false;
    }

    function isntAble(permiso) {
      return !isAble(permiso);
    }
  }
})();
