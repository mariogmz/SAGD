// app/blocks/miller/miller.directive.js

(function() {
  'use strict';

  angular
    .module('blocks.miller')
    .directive('millerColumns', millerColumns);

  millerColumns.$inject = [];

  /* @ngInject */
  function millerColumns() {
    // Usage:
    //
    var directive = {
      bindToController: true,
      controller: MillerController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        oneModel: '=',
        selectedOne: '=',
        selectOneCallback: '=',
        searchOneCallback: '=',
        manyModel: '=',
        selectedMany: '=',
        selectManyCallback: '=',
        searchManyCallback: '=',
        attach: '=',
        relatedModel: '=',
        selectedRelated: '=',
        selectRelatedCallback: '=',
        searchRelatedCallback: '=',
        detach: '='
      },
      templateUrl: 'app/templates/components/miller-columns.html'
    };
    return directive;

    function link(scope, element, attrs) {

    }
  }

  MillerController.$inject = [];

  /* @ngInject */
  function MillerController() {
    var vm = this;
    vm.selectOne = selectOne;
    vm.selectMany = selectMany;
    vm.selectRelated = selectRelated;
    vm.searchOneCallbackWrapper = searchOneCallbackWrapper;
    vm.searchManyCallbackWrapper = searchManyCallbackWrapper;
    vm.showAttachActions = showAttachActions;

    initialize();

    function initialize() {
    }

    function selectOne(element) {
      vm.selectedOne = element;
      if (vm.selectOneCallback) {
        vm.selectOneCallback(vm.selectedOne);
      }
    }

    function selectMany(element) {
      vm.selectedMany = element;
      if (vm.selectManyCallback) {
        vm.selectManyCallback(vm.selectedOne);
      }
    }

    function selectRelated(element) {
      vm.selectedRelated = element;
      if (vm.selectRelatedCallback) {
        vm.selectRelatedCallback(vm.selectedRelated);
      }
    }

    function searchOneCallbackWrapper(element) {
      vm.selectedOne = undefined;
      vm.searchOneCallback(element);
    }

    function searchManyCallbackWrapper(element) {
      vm.selectedMany = undefined;
      vm.searchManyCallback(element);
    }

    function showAttachActions() {
      return Object.keys(vm.selectedOne || {}).length;
    }
  }

})();
