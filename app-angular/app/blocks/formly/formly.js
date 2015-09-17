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
      
      return formlyConfigWrapper;
    }
  }
}());
