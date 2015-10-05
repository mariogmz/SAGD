// app/loader/loader.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.loader')
    .directive('loader', loader);

  loader.$inject = [];

  /* @ngInject */
  function loader() {
    // Usage:
    // <loader model="variable que si es falsa mostrara el spinner"></loader>
    var directive = {
      bindToController: true,
      controller: loaderController,
      controllerAs: 'vm',
      restrict: 'E',
      scope: {
        model: '='
      },
      templateUrl: 'app/loader/loader.template.html'
    };
    return directive;
  }

  /* @ngInject */
  function loaderController() {
    var vm = this;
  }
})();
