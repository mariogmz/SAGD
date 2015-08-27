// app.js

(function () {

  'use strict';

  angular
    .module('sagdApp', [
      'sagdApp.core',

      'sagdApp.layout',
      'sagdApp.dashboard',
      'sagdApp.session',
      'sagdApp.empleado',
      'sagdApp.navbar'
  ]);
})();
