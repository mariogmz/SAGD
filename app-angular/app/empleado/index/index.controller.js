// app/empleado/index/index.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.empleado')
    .controller('empleadoIndexController', EmpleadoIndexController);

  EmpleadoIndexController.$inject = ['$auth', '$state', 'api', 'pnotify', 'modal', 'session'];

  function EmpleadoIndexController($auth, $state, api, pnotify, modal, session){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.empleadoActual = session.obtenerEmpleado();
    vm.sort = sort;
    vm.eliminarEmpleado = eliminar;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Usuario', key: 'usuario'},
      {name: 'Nombre', key: 'nombre'},
      {name: 'Puesto', key: 'puesto'},
      {name: 'Ultimo acceso', key: 'fecha_ultimo_ingreso'}
    ];

    initialize();

    function initialize(){
      return obtenerEmpleados().then(function (){
        console.log("Empleados obtenidos");
      });
    }

    function obtenerEmpleados(){
      var endpoint = "/empleado?sucursal=" + vm.empleadoActual.sucursal_id;
      return api.get(endpoint)
        .then(function (response){
          vm.empleados = response.data;
          return vm.empleados;
        });
    }

    function eliminar(empleado) {
      modal.confirm({
        title: 'Eliminar Empleado',
        content: 'Estas a punto de eliminar una empleado. ¿Estás seguro?',
        accept: 'Eliminar Empleado',
        type: 'danger'
      })
      .then(function(response) {
        modal.hide('confirm');
        eliminarEmpleado(empleado.id);
      })
      .catch(function(response) {
        modal.hide('confirm');
        return false;
      });
    }

    function eliminarEmpleado(id){
      return api.delete('/empleado/', id)
        .then(function (response){
          obtenerEmpleados().then(function(){
            pnotify.alert('¡Exito!', response.data.message, 'success');
          });
        }).catch(function (response){
          pnotify.alert('¡Error!', response.data.message, 'error');
        });
    }

    function sort(keyname){
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

  }

})();
