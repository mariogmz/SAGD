// app/sucursal/edit/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.sucursal')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('sucursalEdit', {
                url: 'sucursal/editar/:id',
                parent: 'sucursal',
                templateUrl: 'app/sucursal/edit/edit.html',
                controller: 'sucursalEditController',
                controllerAs: 'vm'
            });
    }
})();
