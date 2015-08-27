// app/producto/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.producto')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('producto', {
                url: 'producto',
                parent: 'layout',
                templateUrl: 'app/producto/producto.html',
                controller: 'productoController',
                controllerAs: 'vm'
            });
    }
})();
