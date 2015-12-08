// app/blocks/api/api.js

(function() {
  'use strict';

  angular
    .module('blocks.api')
    .factory('api', ApiProvider);

  ApiProvider.$inject = ['$http', 'ENV', 'lscache', 'utils'];

  function ApiProvider($http, ENV, cache, utils) {
    var applicationFqdn = ENV.applicationFqdn;
    var apiNamespace = ENV.apiNamespace;
    var version = ENV.version;
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

    function getResource(resource, parameters, arraybuffer) {
      parameters = parameters ? utils.querify(parameters) : '';

      var unifiedUri = resource + parameters;
      var cached = cache.cached(unifiedUri);

      if (cached) {
        return Promise.resolve(cached);
      } else {
        var response = arraybuffer ?
          $http.get(endpoint + unifiedUri, {responseType: 'arraybuffer'}) :
          $http.get(endpoint + unifiedUri);

        return response.then(function(response) {
            cache.cache(unifiedUri, response);
            return response;
          })
          .catch(function(error) {
            return Promise.reject(error);
          });
      }
    }

    function putResource(resource, parameters, data) {
      parameters = parameters ? parameters : '';
      return $http.put(endpoint + resource + parameters, data)
        .then(function(response) {
          return response;
        })
        .catch(function(error) {
          return Promise.reject(error);
        });
    }

    function postResource(resource, data, arraybuffer) {
      var response = arraybuffer ?
        $http.post(endpoint + resource, data, {responseType: 'arraybuffer'}) :
        $http.post(endpoint + resource, data);
      return response.then(function(response) {
          return response;
        })
        .catch(function(error) {
          return Promise.reject(error);
        });
    }

    function deleteResource(resource, parameters) {
      parameters = parameters ? parameters : '';
      return $http.delete(endpoint + resource + parameters)
        .then(function(response) {
          return response;
        })
        .catch(function(error) {
          return Promise.reject(error);
        });
    }
  }
}());
