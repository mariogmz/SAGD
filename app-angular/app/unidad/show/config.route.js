// app/unidad/show/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.unidad')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('unidadShow', {
                url: 'unidad/:id',
                parent: 'unidad',
                templateUrl: 'app/unidad/show/show.html',
                controller: 'unidadShowController',
                controllerAs: 'vm'
            });
    }
})();
