(function() {
  'use strict';

  angular
    .module('sagdApp.cliente')
    .factory('ClienteComentario', ClienteComentario);

  ClienteComentario.$inject = ['api'];

  /* @ngInject */
  function ClienteComentario(api) {
    var service = {
      functionName: functionName
    };
    return service;

    ////////////////

    function functionName() {
      
    }
  }

})();

