// app/blocks/utils/utils.module.js

(function () {
  'use strict';

  angular
    .module('blocks.utils')
    .factory('utils', utils);

  utils.$inject = [];

  function utils() {
    return function () {

      function pluck(collection, key) {
        var result = angular.isArray(collection) ? [] : {};

        angular.forEach(collection, function(val, i) {
          result[i] = angular.isFunction(key) ? key(val) : val[key];
        });
        return result;
      }

      return {
        pluck : pluck
      };
    }();

  }
}());
