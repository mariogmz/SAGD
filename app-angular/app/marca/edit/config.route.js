// app/marca/edit/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.marca')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('marcaEdit', {
                url: 'marca/editar/:id',
                parent: 'marca',
                templateUrl: 'app/marca/edit/edit.html',
                controller: 'marcaEditController',
                controllerAs: 'vm'
            });
    }
})();
