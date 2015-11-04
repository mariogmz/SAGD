// app/rol/empleados/empleados.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .controller('rolEmpleadosController', rolEmpleadosController);

  rolEmpleadosController.$inject = ['$auth', '$state', '$stateParams', 'api', 'pnotify'];

  /* @ngInject */
  function rolEmpleadosController($auth, $state, $stateParams, api, pnotify) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.rolId = $stateParams.rol;
    vm.rol = [];
    vm.empleados = [];
    vm.empleadosOriginal = [];
    vm.empleadosRol = [];
    vm.rolHas = rolHas;
    vm.rolDoesntHave = rolDoesntHave;
    vm.attach = attachLocal;
    vm.detach = detachLocal;
    vm.back = back;
    vm.toggleActives = toggleActives;

    activate();

    ////////////////

    function activate() {
      obtenerRol().then(function() {
        obtenerEmpleados().then(function() {
          obtenerEmpleadosDelRol(vm.rolId);
        });
      });
    }

    function obtenerRol() {
      return api.get('/rol/', vm.rolId).then(function(response) {
        vm.rol = response.data.rol;
      });
    }

    function obtenerEmpleados() {
      return api.get('/empleado').then(function(response) {
        vm.empleados = response.data;
        vm.empleadosOriginal = vm.empleados;
      });
    }

    function obtenerEmpleadosDelRol(rolId) {
      return api.get('/rol/'+rolId+'/empleados').then(function(response) {
        vm.empleadosRol = response.data.empleados;
      });
    }

    function attach(empleado) {
      var endpoint = '/empleado/'+vm.rolId+'/roles/attach/'+empleado;
      return api.post(endpoint);
    }

    function detach(empleado) {
      var endpoint = '/empleado/'+vm.rolId+'/roles/detach/'+empleado;
      return api.delete(endpoint);
    }

    function attachLocal(empleado) {
      if (rolHas(empleado)) {return};
      attach(empleado.id).then(function(){
        vm.empleadosRol.push(empleado);
      });
    }

    function detachLocal(empleado) {
      if (rolDoesntHave(empleado)) {return};
      detach(empleado.id).then(function() {
        for (var i = vm.empleadosRol.length - 1; i >= 0; i--) {
          if (vm.empleadosRol[i].id === empleado.id){
            vm.empleadosRol.splice(i,1);
            return;
          }
        }
      });
    }

    function rolHas(empleado) {
      for (var i = vm.empleadosRol.length - 1; i >= 0; i--) {
        if (vm.empleadosRol[i].id === empleado.id) {
          return true;
        }
      }
      return false;
    }

    function rolDoesntHave(empleado) {
      return !rolHas(empleado);
    }

    function back() {
      window.history.back();
    }

    function toggleActives() {
      vm.empleados = vm.active ? vm.empleadosRol : vm.empleadosOriginal;
    }
  }
})();
