// app/logs/index/index.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.logs')
    .controller('logsIndexController', logsIndexController);

  logsIndexController.$inject = ['api', 'pnotify'];

  function logsIndexController(api, pnotify){

    var vm = this;

    initialize();

    function initialize(){

    }
  }

})();
