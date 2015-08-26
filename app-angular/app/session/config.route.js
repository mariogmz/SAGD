// app/session/config.route.js

(function() {
    'use strict';

    angular
        .module('sagdApp.session')
        .config(configureRoutes);

    configureRoutes.$inject = ['$stateProvider'];

    function configureRoutes($stateProvider) {
        $stateProvider
            .state('login', {
                url: '/login',
                templateUrl: 'app/session/login.html',
                controller: 'SessionController',
                controllerAs: 'vm'
            })
            .state('logout', {
                url: '/logout',
                templateUrl: 'app/session/logout.html',
                controller: 'SessionController',
                controllerAs: 'vm'
            });
    }
})();
