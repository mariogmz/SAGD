// app/navbar/navbar.directive.js

(function () {

  'use strict';

  angular
    .module('sagdApp.navbar')
    .directive('logout', function () {
      return {
        templateUrl: 'app/session/logout.html'
      };
    });
})();
