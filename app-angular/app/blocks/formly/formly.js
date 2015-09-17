// app/blocks/formly/formly.js

(function (){
  'use strict';

  angular
    .module('blocks.formly')
    .factory('formly.sagd', FormlySagd);

  FormlySagd.$inject = [];

  function FormlySagd(formlyConfigProvider){

    var formlySagd = {
      init: init
    };

    return formlySagd;

    function init(){
      formlyConfigProvider.setType({
        name: 'input',
        template: 'Hello World!'
      });
    }
  }
}());
