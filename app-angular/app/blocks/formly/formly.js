// app/blocks/formly/formly.js

(function (){
  'use strict';

  angular
    .module('blocks.formly')
    .decorator('formlyConfig', FormlyConfigDecorator);

  FormlyConfigDecorator.$inject = ['$delegate'];

  function FormlyConfigDecorator($delegate){

    var formlyConfigWrapper = $delegate;

    return wrap();

    function wrap(){

      /**
       * Common wrappers
       */
      formlyConfigWrapper.setWrapper([
        {
          name: 'label',
          templateUrl: 'app/templates/wrappers/label.html'
        }
      ]);

      var commonWrappers = ['label'];

      formlyConfigWrapper.setType({
        name: 'input',
        templateUrl: 'app/templates/fields/input.html',
        wrapper: commonWrappers
      });
      return formlyConfigWrapper;
    }
  }
}());
