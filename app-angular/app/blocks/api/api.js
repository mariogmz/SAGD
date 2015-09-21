// app/blocks/api/api.js

(function (){
  'use strict';

  angular
    .module('blocks.api')
    .factory('api', ApiProvider);

  ApiProvider.$inject = ['$http'];

  function ApiProvider($http){
    var applicationFqdn = "http://api.sagd.app";
    var apiNamespace = "/api";
    var version = "/v1";
    var endpoint = applicationFqdn + apiNamespace + version;

    var apiProvider = {
      server: applicationFqdn,
      namespace: apiNamespace,
      version: version,
      endpoint: endpoint,
      get: getResource,
      put: putResource,
      post: postResource,
      delete: deleteResource
    };

    return apiProvider;

    function getResource(resource, parameters){
      parameters = parameters ? parameters : "";
      return $http.get(endpoint + resource + parameters)
        .then(function (response){
          return response;
        })
        .catch(function (error){
          return Promise.reject(error);
        });
    }

    function putResource(resource, parameters, data){
      parameters = parameters ? parameters : "";
      return $http.put(endpoint + resource + parameters, data)
        .then(function (response){
          return response;
        })
        .catch(function (error){
          return Promise.reject(error);
        });
    }

    function postResource(resource, data){
      return $http.post(endpoint + resource, data)
        .then(function (response){
          return response;
        })
        .catch(function (error){
          return Promise.reject(error);
        });
    }

    function deleteResource(resource, parameters){
      parameters = parameters ? parameters : "";
      return $http.delete(endpoint + resource + parameters)
        .then(function (response){
          return response;
        })
        .catch(function (error){
          return Promise.reject(error);
        });
    }
  }
}());
