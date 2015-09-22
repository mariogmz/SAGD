// app/proveedor/index/proveedorIndex.controller.js

(function () {
    'use strict';

    angular
        .module('sagdApp.proveedor')
        .controller("proveedorIndexController", ProveedorIndexController);

    ProveedorIndexController.$inject = ['$auth', '$state', '$http'];

    function ProveedorIndexController($auth, $state, $http) {
        if (!$auth.isAuthenticated()) {
            $state.go('login', {});
        }
        var vm = this;

        vm.obtenerProveedores = function () {
            $http.get('http://api.sagd.app/api/v1/proveedor').
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

    function eliminarProveedor(id){
        return api.delete('/proveedor/', id)
            .then(function (response){
                obtenerProveedor().then(function(){
                    pnotify.alert('¡Exito!', response.data.message, 'success');
                });
            }).catch(function (response){
                pnotify.alert('¡Error!', response.data.message, 'error');
            });
    }


})();
