// app/blocks/utils/utils.module.js

(function (){
  'use strict';

  angular
    .module('blocks.utils')
    .factory('utils', utils)
    .filter('percentage', percentage);

  utils.$inject = [];

  function utils(){

    return {
      pluck: pluck,
      strip: stripApiCall,
      querify : querify
    };


    function pluck(collection, key){
      var result = angular.isArray(collection) ? [] : {};

      angular.forEach(collection, function (val, i){
        result[i] = angular.isFunction(key) ? key(val) : val[key];
      });
      return result;
    }

    function stripApiCall(string) {
      return string.replace(/^\//g, '').replace(/(\/|,)/g, '-');
    }

    function querify(parameters){
      if (angular.isArray(parameters)) {
        var paramsUrl = '?';
        parameters = parameters.map(function(param){
          param = $.map(param, function(value, index){return [value];});
          return param.join('=');
        });
        paramsUrl += parameters.join('&');
        return paramsUrl;
      }else{
        return parameters;
      }

    }


  }

  percentage.$inject = ['$filter'];

  function percentage($filter){
    return function (input, decimals){
      return $filter('number')(input * 100, decimals) + '%';
    };
  };
}());
