// app/sucursal/index/sucursalIndex.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .controller('sucursalIndexController', sucursalIndexController);

  sucursalIndexController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  /* @ngInject */
  function sucursalIndexController($auth, $state, api, pnotify) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sucursales = [];
    vm.sort = sort;
    vm.eliminarSucursal = eliminarSucursal;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Nombre', key: 'nombre'},
      {name: 'Horarios', key: 'horarios'},
      {name: 'Ubicacion', key: 'ubicacion'},
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

    function eliminarSucursal(id) {
      return api.delete('/sucursal/', id)
        .then(function (response) {
          obtenerSucursales().then(function () {
            pnotify.alert('Exito', response.data.message, 'success');
          });
        })
        .catch(function (response) {
          pnotify.alert('Error', response.data.message, 'error');
        })
    }

    function sort() {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }
})();
