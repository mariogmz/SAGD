// app/resources/icecat.resource.js
(function() {
  'use strict';

  angular
    .module('sagdApp.resources')
    .factory('Icecat', Icecat);

  Icecat.$inject = ['api'];

  /* @ngInject */
  function Icecat(api, pnotify) {
    var endpoint = '/icecat';
    var modelName = 'Icecat';

    var resource = {
      ficha: obtenerFicha
    };
    return resource;

    //////////////////////////////////////////////////

    function obtenerFicha(numeroParte, marcaId) {
      return api.get(endpoint + '/' + numeroParte + '/marca/' + marcaId)
        .then(obtenerFichaComplete)
        .catch(obtenerFichaFailed);

      function obtenerFichaComplete(response) {
        pnotify.alert('Ficha encontrada', response.data.message, 'info');
        return response.data.ficha;
      }

      function obtenerFichaFailed(error) {
        pnotify.alert(error.data.message, error.data.error, 'error');
      }
    }

  }

})();

