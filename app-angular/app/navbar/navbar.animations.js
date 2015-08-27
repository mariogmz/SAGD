// app/navbar/navbar.animations.js

(function () {

  'use strict';

  angular
    .module('sagdApp.navbar')
    .animation('.module-navbar', NavbarAnimation);

  NavbarAnimation.$inject = [];

  function NavbarAnimation() {

    var showSubmenu = function(element, className, done) {
        var menu = $(element).children('.menu');
        $(menu).addClass('active');
    }

    var hideSubmenu = function(element, className, done) {
        var menu = $(element).children('.menu');
        $(menu).removeClass('active');
    }

    return {
      addClass: showSubmenu,
      removeClass: hideSubmenu
    };
  }

})();
