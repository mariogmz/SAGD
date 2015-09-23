// app/proveedor/index/proveedorIndex.controller.js

(function () {
    'use strict';

    angular
        .module('sagdApp.proveedor')
        .controller("proveedorIndexController", ProveedorIndexController);

    ProveedorIndexController.$inject = ['$auth', '$state', 'api', 'pnotify'];

    function ProveedorIndexController($auth, $state, api, pnotify) {
        if (!$auth.isAuthenticated()) {
            $state.go('login', {});
        }

        var vm = this;

        vm.obtenerProveedores = function () {
            api.get('/proveedor').
                then(function (response) {
                    vm.proveedores = response.data;
                }, function (response) {
                    vm.errors = response;
                });
        };

        vm.obtenerProveedores();

        vm.sort = function (keyname) {
            vm.sortKey = keyname;   //set the sortKey to the param passed
            vm.reverse = !vm.reverse; //if true make it false and vice versa
        }

    }

})();
