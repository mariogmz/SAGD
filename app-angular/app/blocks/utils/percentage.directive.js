// app/blocks/utils/percentage.directive.js

(function() {
  'use strict';

  angular
    .module('blocks.utils')
    .directive('percentage', percentage);

  percentage.$inject = ['utils'];

  /* @ngInject */
  function percentage(utils) {
    // Usage:
    //
    var directive = {
      link: link,
      restrict: 'A',
      require: 'ngModel'
    };
    return directive;

    function link(scope, element, attrs, ngModelCtrl) {

      // Format text going to user (model to view)
      ngModelCtrl.$formatters.push(utils.formatPercentage);

      // Format text from the user (view to model)
      ngModelCtrl.$parsers.push(utils.parsePercentage);
    }
  }
})();
