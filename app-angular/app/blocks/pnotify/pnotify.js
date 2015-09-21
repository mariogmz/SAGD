// app/blocks/pnotify/pnotify.js

(function (){
  'use strict';

  angular
    .module('blocks.pnotify')
    .factory('pnotify', pNotifyProvider);

  pNotifyProvider.$inject = [];

  function pNotifyProvider(){
    // Set default style to bootstrap3, I hope someday this changes to bootstrap4
    PNotify.prototype.options.styling = 'bootstrap3';

    // Defaults
    var stack_context = {
      "dir1": "down",
      "dir2": "left",
      "push": "bottom",
      "spacing1": 15,
      "spacing2": 15,
      context: $("body")
    };

    var pnotify = {
      alert: alert,
      desktopAlert: desktopAlert,
      alertList: alertList
    };

    return pnotify;

    function alert(title, text, type, sticky){
      new PNotify({
        title: title,
        text: text,
        type: type,
        hide: sticky ? false : true,
        stack: stack_context
      });
    }

    function desktopAlert(title, text, type, sticky){
      new PNotify({
        title: title,
        text: text,
        type: type,
        hide: sticky ? false : true,
        desktop: {
          desktop: true
        }
      });
    }

    function alertList(title, list, type){
      var html = '<ul>';
      angular.forEach(list, function (value, key){
        html += '<li><strong>' + key + '</strong><ul>';
        angular.forEach(value, function (value){
          html += '<li>' + value + '</li>';
        });
        html += '</ul></li>';
      });
      html += '</ul>';
      alert(title, html, type, false);
    }

  }
}());
