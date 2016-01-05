// app/cliente/index/clienteIndex.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteIndexController', ClienteIndexController);

  ClienteIndexController.$inject = ['Cliente'];

  /* @ngInject */
  function ClienteIndexController(Cliente) {
    var vm = this;
    vm.sort = sort;
    vm.eliminarProducto = eliminarCliente;

    vm.searching = false;
    vm.delete = eliminarCliente;
    vm.buscar = buscar;

    initialize();

    function initialize() {
      vm.sortKeys = [
        {name: '#', key: 'id'},
        {name: 'Nombre', key: 'nombre'},
        {name: 'Usuario', key: 'usuario'},
        {name: 'Email', key: 'email'}
      ];
      vm.search = {
        nombre: '',
        usuario: '',
        email: ''
      };
    }

    function buscar() {
      vm.searching = true;
      vm.clientes = undefined;
      Cliente.buscar(vm.search).then(success);
    }

    function eliminarCliente(id) {
      return Cliente.delete(id)
        .then(function(response) {
          return response;
        });
    }

    function success(clientes) {
      vm.searching = false;
      vm.clientes = clientes.map(function(cliente) {
        cliente.email = cliente.user ? cliente.user.email : '';
        return cliente;
      });

      return clientes;
    }

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

  }

})();
