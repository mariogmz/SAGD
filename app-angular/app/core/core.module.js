// app/core/core.module.js

(function() {
    'use strict';

    angular.module('sagdApp.core', [
        /*
         * Angular modules
         */
        'ngAnimate',

        /*
         * Our reusable cross app code modules
         */
        'blocks.session',

        /*
         * 3rd party app modules
         */
        'ui.router',
        'satellizer'
    ]);
})();
