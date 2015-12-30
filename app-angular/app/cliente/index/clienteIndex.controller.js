// app/cliente/index/clienteIndex.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteIndexController', ClienteIndexController);

  ClienteIndexController.$inject = ['api', 'pnotify'];

  /* @ngInject */
  function ClienteIndexController(api, pnotify) {
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
      obtenerClientes().then(success).catch(error);
    }

    function obtenerClientes() {
      return api.get('/clientes/buscar/', vm.search);
    }

    function eliminarCliente(id) {
      return api.delete('/cliente/', id)
        .then(function(response) {
          obtenerClientes().then(function() {
            pnotify.alert('¡Exito!', response.data.message, 'success');
          });
        }).catch(function(response) {
          pnotify.alert('¡Error!', response.data.message, 'error');
        });
    }

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

    function success(response) {
      vm.searching = false;
      vm.clientes = response.data.map(function(cliente) {
        cliente.email = cliente.user ? cliente.user.email : '';
        return cliente;
      });

      return response;
    }

    function error(response) {
      vm.searching = false;
      pnotify.alert(response.data.error, response.data.message, 'error');
    }

  }

})();
