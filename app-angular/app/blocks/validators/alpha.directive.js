// app/blocks/validators/alpha.directive.js

(function (){
  'use strict';

  angular
    .module('blocks.validators')
    .directive('alpha', alphaValidator);

  alphaValidator.$inject = [];

  /* @ngInject */
  function alphaValidator(){
    var directive = {
      link: link,
      require: 'ngModel',
      restrict: 'A'
    };
    return directive;

    function link(scope, element, attrs, ngModel){

      // For DOM to Model validation
      ngModel.$parsers.unshift(function(value){
        var valid = /^[a-zA-Z]*$/.test(value);
        ngModel.$setValidity('alpha', valid);
        return valid ? value : undefined;
      });

      // For Model to DOM validation
      ngModel.$formatters.unshift(function(value){
        ngModel.$setValidity('alpha', /^[a-zA-Z]*$/.test(value));
        return value;
      });
    }
  }

})();

