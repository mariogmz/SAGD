// app/empleado/index/index.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.empleado')
    .controller('empleadoIndexController', EmpleadoIndexController);

  EmpleadoIndexController.$inject = ['api', 'pnotify', 'modal', 'session'];

  function EmpleadoIndexController(api, pnotify, modal, session){

    var vm = this;
    vm.showInactive = false;
    vm.showAllSucursales = false;

    vm.empleadoActual = session.obtenerEmpleado();
    vm.sort = sort;
    vm.eliminarEmpleado = eliminar;
    vm.filter = filterCollection;
    vm.empleados = [];
    vm.mainCollection = [];
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Usuario', key: 'usuario'},
      {name: 'Nombre', key: 'nombre'},
      {name: 'Puesto', key: 'puesto'},
      {name: 'Sucursal', key: 'sucursal.id'},
      {name: 'Ultimo acceso', key: 'fecha_ultimo_ingreso'}
    ];

    initialize();

    function initialize(){
      return obtenerEmpleados().then(function (){
        console.log("Empleados obtenidos");
      });
    }

    function obtenerEmpleados(){
      return api.get('/empleado').then(function (response){
          vm.mainCollection = response.data;
          filterCollection();
          return vm.mainCollection;
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
      return api.delete('/empleado/', id).then(function (response){
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

    function filterCollection(property) {
      vm.empleados = [];
      var length = vm.mainCollection.length;
      for (var i = 0; i < length; i++) {
        var empleado = vm.mainCollection[i];
        if (
          (empleado.activo && empleado.sucursal_id === vm.empleadoActual.sucursal_id) ||
          (!empleado.activo && vm.showInactive) ||
          (empleado.activo && vm.showAllSucursales)
        ) {
          vm.empleados.push(empleado);
        };
      };
    }

  }

})();
