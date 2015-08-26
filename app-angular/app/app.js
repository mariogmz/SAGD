// app.js

(function () {

  'use strict';

  angular
    .module('sagdApp', [
      'sagdApp.core',

      'sagdApp.dashboard',
      'sagdApp.session',
      'sagdApp.empleado',
      'sagdApp.navbar'
  ]);
})();
