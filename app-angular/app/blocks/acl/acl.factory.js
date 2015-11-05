// app/blocks/acl/acl.factory.js

(function() {
  'use strict';

  angular
    .module('blocks.acl')
    .factory('aclFactory', aclFactory);

  aclFactory.$inject = ['$injector'];

  /* @ngInject */
  function aclFactory($injector) {
    var service = {
      redirect: redirect,
      login: login,
    };

    return service;

    ////////////////

    function redirect() {
      $injector.get('$state').go('unauthorized', {});
    }

    function login() {
      $injector.get('$state').go('login', {});
    }
  }
})();
