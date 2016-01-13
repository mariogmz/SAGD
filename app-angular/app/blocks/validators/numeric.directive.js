// app/blocks/validators/numeric.directive.js

(function() {
  'use strict';

  angular
    .module('blocks.validators')
    .directive('numeric', numeric);

  numeric.$inject = [];

  /* @ngInject */
  function numeric() {
    var directive = {
      link: link,
      require: 'ngModel',
      restrict: 'A'
    };
    return directive;

    function link(scope, element, attrs, ngModel) {

      // For DOM to Model validation
      ngModel.$parsers.unshift(function(value) {
        var valid = /^[0-9]*(\.[0-9]{1,2})?$/.test(value);
        ngModel.$setValidity('numeric', valid);
        return valid ? value : undefined;
      });
      ngModel.$parsers.push(function(value) {
        return '' + value;
      });

      // For Model to DOM validation
      ngModel.$formatters.unshift(function(value) {
        ngModel.$setValidity('numeric', /^[0-9]+(\.[0-9]{1,2})?$/.test(value));
        return value;
      });
      ngModel.$formatters.push(function(value) {
        return parseFloat(value, 2);
      });
    }
  }
})();

