// app/subfamilia/index/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.subfamilia')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('subfamiliaIndex', {
                url: 'subfamilia',
                parent: 'subfamilia',
                templateUrl: 'app/subfamilia/index/index.html',
                controller: 'subfamiliaIndexController',
                controllerAs: 'vm'
            });
    }
})();
