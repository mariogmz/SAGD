// app/logs/index/index.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.logs')
    .controller('logsIndexController', logsIndexController);

  logsIndexController.$inject = ['$state'];

  /* @ngInject */
  function logsIndexController($state) {

    var vm = this;

    initialize();

    function initialize() {
      $state.go('logsAcceso');
    }
  }

})();
