// app/cliente/index/clienteIndex.controller.js

(function () {
    'use strict';

    angular
        .module('sagdApp.cliente')
        .controller("clienteIndexController", ClienteIndexController);

    ClienteIndexController.$inject = ['api', 'pnotify'];

    function ClienteIndexController(api, pnotify) {

        var vm = this;
        vm.eliminarCliente = eliminarCliente;
        vm.sort = sort;
        vm.sortKeys = [
            {name: '#', key: 'id'},
            {name: 'Usuario', key: 'usuario'},
            {name: 'Nombre', key: 'nombre'},
            {name: 'Estatus', key: 'estatus.id'},
        ];

        vm.obtenerClientes = function () {
            api.get('/cliente').
                then(function (response) {
                    vm.clientes = response.data;
                }, function (response) {
                    vm.errors = response;

                });
        };

        vm.obtenerClientes();

        function eliminarCliente(id) {
            return api.delete('/cliente/', id)
                .then(function(response){
                    pnotify.alert('Exito', response.data.message, 'success');
                    vm.obtenerClientes();
                })
                .catch(function(response){
                    pnotify.alert('Error', response.data.message, 'error');
                });
        }

        function sort(keyname){
            vm.sortKey = keyname;
            vm.reverse = !vm.reverse;
        }

    }

})();
