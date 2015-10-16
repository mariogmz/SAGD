// app/blocks/notifications/notifications.factory.js

(function() {
  'use strict';

  angular
    .module('blocks.notifications')
    .factory('notifications', notifications);

  notifications.$inject = ['ENV', 'socketFactory'];

  /* @ngInject */
  function notifications(ENV, socketFactory) {
    var socket = socketFactory({
      prefix: '',
      ioSocket: io.connect(ENV.socketEndpoint)
    });

    return socket;
  }
})();
