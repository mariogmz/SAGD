// app/blocks/pnotify/pnotify.js

(function() {
  'use strict';

  angular
    .module('blocks.pnotify')
    .factory('pnotify', pNotifyProvider);

  pNotifyProvider.$inject = [];

  /* @ngInject */
  function pNotifyProvider() {
    // Set default style to bootstrap3, I hope someday this changes to bootstrap4
    setStyling();

    // Defaults
    var stack_context = {
      dir1: 'down',
      dir2: 'left',
      push: 'bottom',
      spacing1: 15,
      spacing2: 15,
      context: $('body')
    };

    var delay = 4000;

    var pnotify = {
      alert: alert,
      desktopAlert: desktopAlert,
      alertList: alertList
    };

    return pnotify;

    function setStyling() {
      var theme = 'sagd';
      PNotify.prototype.options.styling = theme;
      $.extend(PNotify, {
        styling: {
          sagd: {
            container: 'sagd-alert',
            notice: 'sagd-alert-warning',
            info: 'sagd-alert-info',
            success: 'sagd-alert-success',
            error: 'sagd-alert-danger',
          }
        }
      });
    }

    function alert(title, text, type, sticky) {
      new PNotify({
        title: title,
        text: text,
        type: type,
        hide: sticky ? false : true,
        delay: delay,
        nonblock: {
          nonblock: true,
          nonblock_opacity: .2
        },
        stack: stack_context
      });
    }

    function desktopAlert(title, text, type, sticky) {
      new PNotify({
        title: title,
        text: text,
        type: type,
        hide: sticky ? false : true,
        delay: delay,
        desktop: {
          desktop: true
        }
      });
    }

    function alertList(title, list, type) {
      var html = '<ul>';
      if (typeof list == 'string') {
        return alert(title, list, type);
      }

      angular.forEach(list, function(value, key) {
        html += '<li><strong>' + key + '</strong><ul>';
        angular.forEach(value, function(value) {
          html += '<li>' + value + '</li>';
        });

        html += '</ul></li>';
      });

      html += '</ul>';
      alert(title, html, type, false);
    }

  }
}());
