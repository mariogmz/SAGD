// app/empleado/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.empleado')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('empleado', {
                url: '/empleado',
                templateUrl: 'app/empleado/empleado.html',
                controller: 'EmpleadoController',
                controllerAs: 'vm'
            });
    }
})();
