// app.js

(function () {

  'use strict';

  angular
    .module('sagdApp', [
      'sagdApp.core',

      'sagdApp.layout',
      'sagdApp.home',
      'sagdApp.session',
      'sagdApp.empleado',
      'sagdApp.producto',
      'sagdApp.margen',
      'sagdApp.navbar'
  ]);
})();
