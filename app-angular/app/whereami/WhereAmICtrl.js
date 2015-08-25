// app/whereami/WhereAmICtrl.js

(function () {

  'use strict';

  angular
    .module('sagdApp')
    .controller('WhereAmIController', WhereAmIController)
    .directive('waiBar', function () {
      return {
        templateUrl: 'app/whereami/waibar.html'
      };
    });

  WhereAmIController.$inject = ['$auth','stateService'];

  function WhereAmIController($auth, stateService) {
    var vm = this;
    vm.isAuthenticated = $auth.isAuthenticated;
    vm.state = stateService.state;
  }

})();
