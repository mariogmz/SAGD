// app/sidebar/sidebar.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.sidebar')
    .directive('sidebar', sidebar);

  sidebar.$inject = [];

  /* @ngInject */
  function sidebar() {
    // Usage:
    //
    // Creates:
    //
    var directive = {
      bindToController: true,
      controller: SidebarController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
      },
      templateUrl: 'app/sidebar/sidebar.template.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  SidebarController.$inject = ['notifications']

  /* @ngInject */
  function SidebarController(notifications) {
    var vm = this;
    vm.collection = '';

    notifications.on('sucursales:App\\Events\\SucursalVista', function(data){
      addNotification();
    });


    function addNotification() {
      var template = "\
<div class='card card-inverse card-primary text-center'>\
  <div class='card-block'>\
      <blockquote class='card-blockquote'>\
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>\
        <footer>Someone famous in <cite title='Source Title'>Source Title</cite></footer>\
      </blockquote>\
  </div>\
</div>";
      var target = $("#notification-bar");
      target.append(template);
    }
  }
})();
