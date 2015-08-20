var WorldFactory, zombie;

zombie = require('zombie');

WorldFactory = function(callback) {
  'use strict';
  var world;
  this.browser = new zombie;
  world = {
    browser: this.browser,
    visit: function(url, callback) {
      this.browser.visit(url, callback);
    }
  };
  callback(world);
};

module.exports.World = WorldFactory;
