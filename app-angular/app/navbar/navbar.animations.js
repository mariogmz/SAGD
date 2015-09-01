// app/navbar/navbar.animations.js

(function () {

  'use strict';

  angular
    .module('sagdApp.navbar')
    .animation('.module-navbar', NavbarAnimation);

  NavbarAnimation.$inject = [];

  function NavbarAnimation() {

    var showSubmenu = function (element, className, done) {
      var menu = $(element).children('.menu');
      $(menu).addClass('active');
    };

    var hideSubmenu = function (element, className, done) {
      var menu = $(element).children('.menu');
      $(menu).removeClass('active');
    };

    var setActive = function (element, className, done) {
      $('li.module-navbar').each(function () {
        $(this).removeClass('active');
      });
      $(element).addClass('active');
    };

    var addClass = function(element, className, done) {
      if (className === 'active') {
        setActive(element, className, done);
      } else {
        showSubmenu(element, className, done);
      }
    };

    return {
      addClass: addClass,
      removeClass: hideSubmenu
    };
  }

})();
