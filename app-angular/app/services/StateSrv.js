// app/dashboard/StateSrv.js

(function () {

  'use strict';

  angular
    .module('sagdApp')
    .service('stateService', StateService);

  function StateService() {
    var vm = this;
    vm.state = '';
  }
})();
