// app/blocks/printer/printer.js

(function() {
  'use strict';

  angular
    .module('blocks.printer')
    .factory('printer', printer);

  printer.$inject = [];

  /* @ngInject */
  function printer() {
    var service = {
      send: send
    };

    return service;

    ////////////////

    function send(response) {
      var file = new Blob([response.data], {type: 'application/pdf'});
      var fileURL = URL.createObjectURL(file);
      var ventana = window.open(fileURL);
      ventana.print();
      return Promise.resolve(true);
    }
  }
})();
