// app/margen/edit/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.margen')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('margenEdit', {
                url: 'margen/editar/:id',
                parent: 'margen',
                templateUrl: 'app/margen/edit/edit.html',
                controller: 'margenEditController',
                controllerAs: 'vm'
            });
    }
})();
