// app/blocks/acl/acl.factory.js

(function() {
  'use strict';

  angular
    .module('blocks.acl')
    .factory('acl', acl);

  acl.$inject = [];

  /* @ngInject */
  function acl() {
    var acl = false;
    var service = {
      setUnauthorizedAccess: setUnauthorizedAccess,
      clearUnauthorizedAccess: clearUnauthorizedAccess,
      getUnauthorizedAccess: getUnauthorizedAccess
    };

    return service;

    ////////////////

    function setUnauthorizedAccess() {
      acl = true;
    }

    function clearUnauthorizedAccess() {
      acl = false;
    }

    function getUnauthorizedAccess() {
      return acl;
    }
  }
})();
