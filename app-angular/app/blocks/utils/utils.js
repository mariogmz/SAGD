// app/blocks/utils/utils.module.js

(function (){
  'use strict';

  angular
    .module('blocks.utils')
    .factory('utils', utils)
    .factory('api', api)
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

  function api(){
    var applicationFqdn = "http://api.sagd.app";
    var apiNamespace = "/api";
    var version = "/v1";

    return {
      rootPath: applicationFqdn,
      namespace: apiNamespace,
      version: version,
      endpoint: applicationFqdn + apiNamespace + version
    }
  }

  percentage.$inject = ['$filter'];

  function percentage($filter){
    return function (input, decimals){
      return $filter('number')(input * 100, decimals) + '%';
    };
  };
}());
