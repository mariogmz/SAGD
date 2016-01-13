// app/cliente/index/clienteIndex.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteIndexController', ClienteIndexController);

  ClienteIndexController.$inject = ['Cliente', 'modal'];

  /* @ngInject */
  function ClienteIndexController(Cliente, modal) {
    var vm = this;
    vm.sort = sort;
    vm.eliminarProducto = eliminarCliente;

    vm.searching = false;
    vm.delete = eliminar;
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

    function eliminar(cliente) {
      modal.confirm({
          title: 'Eliminar cliente ' + cliente.nombre,
          content: 'Estás a punto de eliminar un cliente. ¿Estás seguro?',
          accept: 'Eliminar cliente',
          type: 'danger'
        })
        .then(function(response) {
          modal.hide('confirm');
          return eliminarCliente(cliente.id);
        })
        .catch(function(response) {
          modal.hide('confirm');
          return false;
        });
    }

    function eliminarCliente(id) {
      return Cliente.delete(id)
        .then(function(response) {
          return buscar();
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
