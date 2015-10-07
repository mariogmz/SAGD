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
      addNotification(data.data);
    });


    function addNotification(data) {
      var template = "<p>"+data.usuario +": "+data.mensaje+"</p>";
      var target = $("#listener");
      target.prepend(template);
    }
  }
})();
