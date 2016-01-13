// app/proveedor/index/proveedorIndex.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.proveedor')
    .controller('proveedorIndexController', ProveedorIndexController);

  ProveedorIndexController.$inject = ['api'];

  /* @ngInject */
  function ProveedorIndexController(api) {

    var vm = this;
    vm.sort = sort;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Razón social', key: 'razon_social'},
      {name: 'Página web', key: 'pagina_web'}
    ];

    vm.obtenerProveedores = function() {
      api.get('/proveedor').then(function(response) {
        vm.proveedores = response.data;
      }, function(response) {
        vm.errors = response;
      });
    };

    vm.obtenerProveedores();

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

  }

})();
