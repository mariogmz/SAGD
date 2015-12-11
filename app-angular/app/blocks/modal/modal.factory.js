// app/blocks/modal/modal.factory.js

(function() {
  'use strict';

  angular
    .module('blocks.modal')
    .factory('modal', modal);

  modal.$inject = ['api', 'session'];

  /* @ngInject */
  function modal(api, session) {
    var modal = '';
    var passwordDOM = '';
    var empleado = session.obtenerEmpleado();
    var service = {
      confirm: confirm,
      password: password,
      hide: hide
    };

    return service;

    ////////////////

    function confirm(config) {
      modal = $('#confirm-modal');
      initialSetupForModal(modal, config);

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

    function password(config) {
      modal = $('#password-confirm-modal');
      initialSetupForModal(modal, config);
      passwordDOM = $('#modal-password-input');

      return new Promise(function(resolve, reject) {
        modal
        .on('click', '#modal-accept', function(event) {
          checkLegitness().then(function() {
            passwordDOM.val('');
            modal.modal('hide');
            resolve({click: true});
          });
        })
        .on('click', '#modal-dismiss', function(event) {
          passwordDOM.val('');
          modal.modal('hide');
          reject({click: false});
        });
      });
    }

    function initialSetupForModal(modal, config) {
      configureModal(modal, config);
      modal.modal('show');
      setTimeout(function() {
        modal.find('#modal-dismiss').focus();
      }, 400);
    }

    function checkLegitness() {
      var payload = {
        email: empleado.user.email,
        password: passwordDOM.val()
      };
      return api.post('/password/verify', payload);
    }

    /* Deprecated */
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
