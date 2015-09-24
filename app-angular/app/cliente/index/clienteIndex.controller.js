// app/cliente/index/clienteIndex.controller.js

(function () {
    'use strict';

    angular
        .module('sagdApp.cliente')
        .controller("clienteIndexController", ClienteIndexController);

    ClienteIndexController.$inject = ['$auth', '$state', 'api', 'pnotify'];

    function ClienteIndexController($auth, $state, api, pnotify) {
        if (!$auth.isAuthenticated()) {
            $state.go('login', {});
        }

        var vm = this;
        vm.sort = sort;
        vm.sortKeys = [
            {name: '#', key: 'id'},
            {name: 'Clave', key: 'clave'},
            {name: 'Usuario', key: 'usuario'},
            {name: 'Nombre', key: 'nombre'}
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

        function sort(keyname){
            vm.sortKey = keyname;
            vm.reverse = !vm.reverse;
        }

    }

})();
