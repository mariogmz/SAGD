// app/blocks/index/index.directive.js

(function() {
  'use strict';

  angular
    .module('blocks.index')
    .directive('index', index);

  index.$inject = [];

  /* @ngInject */
  function index() {
    // Usage:
    // <index elements="{elementArray}" cols="{#OfColumns}"></index>
    // where elements should be an array as showing next:
    // [{label: 'Fabricantes', state: 'icecatSuppliersIndex', picUrl: '', icon: 'industry'}]
    // label and state are mandatory, while state must be a registered state on ui-router
    // picUrl and icon should not be used together.
    // icon must be a font-awesome icon name without the "fa" prefix, name only
    var directive = {
      bindToController: true,
      controller: IndexController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        elements: '=',
        cols: '='
      },
      templateUrl: 'app/templates/components/index.html'
    };
    return directive;

    function link(scope, element, attrs) {

    }
  }

  IndexController.$inject = [];

  /* @ngInject */
  function IndexController() {
    var vm = this;
    vm.colWidth = Math.round(12 / (vm.cols || 1));
  }
})();

