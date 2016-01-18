// app/blocks/sheet/sheet.directive.js
(function() {
  'use strict';

  angular
    .module('blocks.sheet')
    .directive('sheet', sheet);

  sheet.$inject = [];

  /* @ngInject */
  function sheet() {
    var directive = {
      bindToController: true,
      controller: sheetController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        model: '='
      },
      templateUrl: 'app/templates/components/sheet.html'
    };
    return directive;

    function link(scope, element, attrs) {

    }
  }

  sheetController.$inject = [];

  /* @ngInject */
  function sheetController() {
    var vm = this;
    vm.sheetNotFound = sheetNotFound;

    initialize();

    function initialize() {
    }

    function sheetNotFound() {
      if (typeof vm.model == 'undefined') {
        return true;
      } else {
        return Object.keys(vm.model).length == 0;
      }
    }

  }
})();

