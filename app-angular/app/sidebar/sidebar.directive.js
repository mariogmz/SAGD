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
    vm.collection = [];

    notifications.on('info', function(data) {
      addInfo(data.data.payload);
    });

    notifications.on('saved', function(data) {
      addInfo(data.data.payload);
    });

    function addInfo(payload) {
      vm.collection.push(payload);
    }
  }
})();
