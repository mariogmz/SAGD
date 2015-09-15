// app/blocks/utils/utils.module.js

(function (){
  'use strict';

  angular
    .module('blocks.utils')
    .factory('utils', utils)
    .filter('percentage', percentage);

  utils.$inject = [];

  function utils(){

    function pluck(collection, key){
      var result = angular.isArray(collection) ? [] : {};

      angular.forEach(collection, function (val, i){
        result[i] = angular.isFunction(key) ? key(val) : val[key];
      });
      return result;
    }

    return {
      pluck: pluck
    };

  }

  percentage.$inject = ['$filter'];

  function percentage($filter){
    return function (input, decimals){
      return $filter('number')(input * 100, decimals) + '%';
    };
  };
}());
