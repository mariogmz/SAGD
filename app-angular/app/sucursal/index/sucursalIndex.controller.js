// app/sucursal/index/sucursalIndex.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .controller('sucursalIndexController', sucursalIndexController);

  sucursalIndexController.$inject = ['$auth', '$state', 'api', 'pnotify', 'modal'];

  /* @ngInject */
  function sucursalIndexController($auth, $state, api, pnotify, modal) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sort = sort;
    vm.eliminarSucursal = eliminar;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Nombre', key: 'nombre'},
      {name: 'Proveedor', key: 'proveedor'},
      {name: 'Domicilio', key: 'domicilio'},
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerSucursales()
        .then(function (){
          console.log("Sucursales obtenidas");
        });
    }

    function obtenerSucursales() {
      return api.get('/sucursal')
        .then(function (response) {
          vm.sucursales = response.data;
          return vm.sucursales;
        })
        .catch(function (response) {
          pnotify.alert('Error', response.data.message, 'error');
        });
    }

    function eliminar(sucursal) {
      modal.confirm({
        title: 'Eliminar Sucursal',
        content: 'Estas a punto de eliminar la sucursal ' + sucursal.nombre + '. ¿Estás seguro?',
        accept: 'Eliminar Sucursal',
        type: 'danger'
      })
      .then(function(response) {
        modal.hide('confirm');
        eliminarSucursal(sucursal);
      })
      .catch(function(response) {
        modal.hide('confirm');
        return false;
      });
    }

    function eliminarSucursal(sucursal) {
      return api.delete('/sucursal/', sucursal.id)
        .then(function (response) {
          obtenerSucursales().then(function () {
            pnotify.alert('Exito', response.data.message, 'success');
          });
        })
        .catch(function (response) {
          pnotify.alert('Error', response.data.message, 'error');
        })
    }

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }
})();
