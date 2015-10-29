// app/blocks/validators/alpha.directive.js

(function (){
  'use strict';

  angular
    .module('blocks.validators')
    .directive('alphanum', alphaNumValidator);

  alphaNumValidator.$inject = [];

  /* @ngInject */
  function alphaNumValidator(){
    var directive = {
      link: link,
      require: 'ngModel',
      restrict: 'A'
    };
    return directive;

    function link(scope, element, attrs, ngModel){

      // For DOM to Model validation
      ngModel.$parsers.unshift(function (value){
        var valid = /^[a-zA-Z0-9\s]*$/.test(value);
        ngModel.$setValidity('alphanum', valid);
        return valid ? value : undefined;
      });

      // For Model to DOM validation
      ngModel.$formatters.unshift(function (value){
        ngModel.$setValidity('alphanum', /^[a-zA-Z0-9\s]*$/.test(value));
        return value;
      });
    }
  }

})();

