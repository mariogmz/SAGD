// app/blocks/utils/utils.module.js

(function() {
  'use strict';

  angular
    .module('blocks.utils')
    .factory('utils', utils)
    .filter('percentage', percentage);

  utils.$inject = [];

  /* @ngInject */
  function utils() {

    return {
      pluck: pluck,
      strip: stripApiCall,
      querify: querify,
      formatPercentage: formatPercentage,
      parsePercentage: parsePercentage,
      setClass: setClass,
      whichTab: whichTab
    };

    function pluck(collection, key) {
      var result = angular.isArray(collection) ? [] : {};

      angular.forEach(collection, function(val, i) {
        result[i] = angular.isFunction(key) ? key(val) : val[key];
      });

      return result;
    }

    function stripApiCall(string) {
      return string.replace(/^\//g, '').replace(/(\/|,)/g, '-');
    }

    function querify(parameters) {
      if (angular.isArray(parameters)) {
        var paramsUrl = '?';
        parameters = parameters.map(function(param) {
          param = $.map(param, function(value, index) {
            return [value];
          });

          return param.join('=');
        });

        paramsUrl += parameters.join('&');
        return paramsUrl;
      } else if (angular.isObject(parameters)) {
        var paramsUrl = '?';
        parameters = $.map(parameters, function(value, key) {
          value = value.length === 0 ? '*' : value;
          return key + '=' + value;
        });

        paramsUrl += parameters.join('&');
        return paramsUrl;
      } else {
        return parameters;
      }

    }

    function formatPercentage(value) {
      return ((value || 0) * 100) + ' %';
    }

    function parsePercentage(value) {
      return (value || '').replace(/[^0-9\.]/g, '');
    }

    function setClass(field) {
      return {
        'with-error': checkWithError(field),
        'with-success': checkWithSuccess(field)
      };
    }

    function checkWithError(field) {
      return field.$touched && field.$invalid;
    }

    function checkWithSuccess(field) {
      return field.$touched && field.$valid;
    }

    function whichTab(tabName) {
      var hashTab = tabName;
      var tab = document.querySelector('[href="#' + hashTab + '"]');
      var view = document.querySelector('#' + hashTab);

      if (tab && view) {
        view.setAttribute('class', 'in active');
        tab.setAttribute('class', 'active');
      }
    }

  }

  percentage.$inject = ['$filter'];

  function percentage($filter) {
    return function(input, decimals) {
      return $filter('number')(input * 100, decimals) + '%';
    };
  }
}());
