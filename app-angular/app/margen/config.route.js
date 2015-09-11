// app/margen/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.margen')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('margen', {
                url: 'margen',
                parent: 'layout',
                templateUrl: 'app/margen/margen.html',
                controller: 'margenController',
                controllerAs: 'vm'
            });
    }
})();
