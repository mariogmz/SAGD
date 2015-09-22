// app/unidad/index/index.controller.js

(function() {
    'use strict';

    angular
        .module('sagdApp.unidad')
        .controller('unidadIndexController', unidadIndexController);

    unidadIndexController.$inject = ['$auth', '$state', 'api', 'pnotify'];

    /* @ngInject */
    function unidadIndexController($auth, $state, api, pnotify) {
        if (!$auth.isAuthenticated()) {
            $state.go('login', {});
        }

        var vm = this;
        vm.sort = sort;
        vm.eliminarUnidad = eliminarUnidad;
        vm.sortKeys = [
            {name: '#', key: 'id'},
            {name: 'Clave', key: 'clave'},
            {name: 'Nombre', key: 'nombre'},
        ];

        activate();

        ////////////////

        function activate() {
            return obtenerUnidades().then(function (){
                console.log('Unidades obtenidas');
            })
        }

        function obtenerUnidades(){
            return api.get('/unidad')
                .then(function(response){
                    vm.unidades = response.data;
                    return vm.unidades;
                });
        }

        function eliminarUnidad(id) {
            return api.delete('/unidad/', id)
                .then(function(response){
                    obtenerUnidades().then(function() {
                        pnotify.alert('¡Éxito!', response.data.message, 'success');
                    });
                })
                .catch(function(response){
                    pnotify.alert('¡Error!', response.data.message, 'error');
                });
        }

        function sort(keyname){
            vm.sortKey = keyname;
            vm.reverse = !vm.reverse;
        }
    }
})();
