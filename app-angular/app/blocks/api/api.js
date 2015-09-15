// app/blocks/api/api.js

(function (){
  'use strict';

  angular
    .module('blocks.api')
    .factory('api', api);

  api.$inject = [];

  function api(){
    var applicationFqdn = "http://api.sagd.app";
    var apiNamespace = "/api";
    var version = "/v1";

    var apiProvider = {
      rootPath: applicationFqdn,
      namespace: apiNamespace,
      version: version,
      endpoint: applicationFqdn + apiNamespace + version
    };

    return apiProvider;
  }
}());
