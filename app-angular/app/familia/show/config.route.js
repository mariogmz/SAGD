// app/familia/show/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.familia')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('familiaShow', {
                url: 'familia/:id',
                parent: 'familia',
                templateUrl: 'app/familia/show/show.html',
                controller: 'familiaShowController',
                controllerAs: 'vm'
            });
    }
})();
