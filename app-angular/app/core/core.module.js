// app/core/core.module.js

(function (){
  'use strict';

  angular.module('sagdApp.core', [
    /*
     * Angular modules
     */
    'ngAnimate',

    /*
     * Our reusable cross app code modules
     */
    'blocks.session', 'blocks.state', 'blocks.utils',
    'blocks.api', 'blocks.formly', 'blocks.pnotify',
    'blocks.env', 'blocks.modal',

    /*
     * 3rd party app modules
     */
    'ui.router',
    'satellizer',
    'angularUtils.directives.dirPagination',
    'formly'
  ]);
})();
