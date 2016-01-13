// app/blocks/api/api.factory.js

(function() {
  'use strict';

  angular
    .module('blocks.api')
    .factory('apiObserver', apiObserver);

  apiObserver.$inject = ['$q', 'aclFactory'];

  /* @ngInject */
  function apiObserver($q, aclFactory) {
    var service = {
      responseError: function(errorResponse) {
        if (errorResponse.status === 403) {
          aclFactory.redirect();
        }

        if (errorResponse.status === 401) {
          aclFactory.login();
        }

        if (errorResponse.status === 400 &&
          typeof errorResponse.data !== 'undefined' &&
          errorResponse.data.error === 'token_not_provided') {
          aclFactory.login();
        }

        return $q.reject(errorResponse);
      },

      response: function(response) {
        return response;
      }
    };

    return service;

    ////////////////
  }
})();
