// app/marca/new/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.marca')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('marcaNew', {
                url: 'marca/nueva',
                parent: 'marca',
                templateUrl: 'app/marca/new/new.html',
                controller: 'marcaNewController',
                controllerAs: 'vm'
            });
    }
})();
