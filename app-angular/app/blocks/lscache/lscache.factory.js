// app/blocks/lscache/lscache.factory.js

(function() {
  'use strict';

  angular
    .module('blocks.lscache')
    .factory('lscache', lscacheFactory);

  lscacheFactory.$inject = ['utils', 'ENV'];

  /* @ngInject */
  function lscacheFactory(utils, ENV) {
    var service = {
      cached: cached,
      cache: cache
    };

    return service;

    ////////////////

    function cached(resource) {
      resource = utils.strip(resource);
      return whitelisted(resource) ? lscache.get(resource) : false;
    }

    function cache(resource, response) {
      resource = utils.strip(resource);
      if (whitelisted(resource))
        lscache.set(resource, response, ENV.cache_time);
    }

    function whitelisted(res) {
      return ENV.cache_whitelist.indexOf(res) > 0;
    }
  }
})();
