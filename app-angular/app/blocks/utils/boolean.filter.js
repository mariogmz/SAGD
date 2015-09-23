// app/blocks/utils/boolean.filter.js

(function() {
  'use strict';

  angular
    .module('blocks.utils')
    .filter('boolean', boolean);

  function boolean() {
    return booleanFilter;

    ////////////////

    function booleanFilter(value) {
      return value === 1 ? 'Si' : 'No';
    }
  }
})();
