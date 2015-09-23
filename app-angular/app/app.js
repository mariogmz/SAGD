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
      'sagdApp.marca',
      'sagdApp.familia',
      'sagdApp.subfamilia',
      'sagdApp.navbar',
      'sagdApp.cliente'
  ]);
})();
