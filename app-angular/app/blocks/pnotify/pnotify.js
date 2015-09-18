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
    var self = this;
    self.title = 'SAGD';
    self.text = 'Mensaje';

    var pnotify = {
      alert: alert
    };

    return pnotify;

    function alert(title, text){
      new PNotify({
        title: title | self.title,
        text: text | self.text
      })
    }
  }
}());
