// app/blocks/api/api.factory.js

(function() {
  'use strict';

  angular
    .module('blocks.api')
    .factory('apiObserver', apiObserver);

  apiObserver.$inject = ['$q', 'acl'];

  /* @ngInject */
  function apiObserver($q, acl) {
    var service = {
      responseError: function (errorResponse) {
        if (errorResponse.status === 403) {
          acl.setUnauthorizedAccess();
          return $q.reject(errorResponse);
        }
      },
      response: function (response) {
        acl.clearUnauthorizedAccess();
        return response;
      }
    };

    return service;

    ////////////////
  }
})();
