// app/producto/index/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.producto')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('productoIndex', {
                url: 'producto',
                parent: 'producto',
                templateUrl: 'app/producto/index/index.html',
                controller: 'productoIndexController',
                controllerAs: 'vm'
            });
    }
})();
