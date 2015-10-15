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

  SidebarController.$inject = ['notifications', 'session']

  /* @ngInject */
  function SidebarController(notifications, session) {
    var vm = this;
    vm.collection = [];
    vm.saved = [];

    notifications.emit('fetch', session.obtenerEmpleado());

    notifications.on('info', function(data) {
      addNewToCollection(data.data.payload);
      addToCollection(data.data.payload);
    });

    notifications.on('warn', function(data) {
      addNewToCollection(data.data.payload);
      addToCollection(data.data.payload);
    });

    function addNewToCollection(payload) {
      payload.isNew = true;
    }

    function addToCollection(payload) {
      vm.collection.unshift(payload);
      if (vm.collection.length > 50) {
        vm.collection.pop();
      }
    }
  }
})();
