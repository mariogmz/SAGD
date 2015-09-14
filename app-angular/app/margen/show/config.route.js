// app/margen/show/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.margen')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('margenShow', {
                url: 'margen/:id',
                parent: 'margen',
                templateUrl: 'app/margen/show/show.html',
                controller: 'margenShowController',
                controllerAs: 'vm'
            });
    }
})();
