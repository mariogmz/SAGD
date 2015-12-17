// app/blocks/modal/modal.factory.js

(function() {
  'use strict';

  angular
    .module('blocks.modal')
    .factory('modal', modal);

  modal.$inject = [];

  /* @ngInject */
  function modal() {
    var modal = '';
    var service = {
      confirm: confirm,
      hide: hide
    };

    return service;

    ////////////////

    function confirm(config) {
      modal = $('#confirm-modal');
      configureModal(modal, config);
      modal.modal('show');
      setTimeout(function() {
        modal.find('#modal-dismiss').focus();
      }, 400);

      return new Promise(function(resolve, reject) {
        modal
        .on('click', '#modal-accept', function(event) {
          resolve({click: true});
        })
        .on('click', '#modal-dismiss', function(event) {
          reject({click: false});
        });
      });
    }

    function hide(type) {
      modal = $('#' + type + '-modal');
      modal.modal('hide');
    }

    function configureModal(modal, config) {
      config.title      ? modal.find('#modal-title').text(config.title)             : '';
      config.content    ? modal.find('#modal-content').text(config.content)         : '';
      config.dismiss    ? modal.find('#modal-dismiss').text(config.dismiss)         : '';
      config.accept     ? modal.find('#modal-accept').text(config.accept)           : '';
      config.type       ? modal.find('#modal-accept').addClass('btn btn-' + config.type) : '';
    }
  }
})();
