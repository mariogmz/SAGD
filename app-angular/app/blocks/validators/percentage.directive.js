// app/blocks/utils/percentage.directive.js

(function() {
  'use strict';

  angular
    .module('blocks.validators')
    .directive('percentage', percentage);

  percentage.$inject = ['utils'];

  /* @ngInject */
  function percentage(utils) {
    var directive = {
      link: link,
      require: 'ngModel',
      restrict: 'A'
    };
    return directive;

    function link(scope, element, attrs, ngModel) {

      // Format text going to user (model to view)
      ngModel.$formatters.push(utils.formatPercentage);

      // Format text from the user (view to model)
      ngModel.$parsers.push(utils.parsePercentage);
    }
  }
})();
