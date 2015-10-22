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

  SidebarController.$inject = ['notifications', 'session', '$timeout'];

  /* @ngInject */
  function SidebarController(notifications, session, $timeout) {
    var vm = this;
    vm.collapsed = false;
    vm.showError = true;
    vm.showInfo = true;
    vm.showWarn = true;
    vm.collection = [];
    vm.saved = [];
    vm.removeNotification = deleteNotification;
    vm.toggle = toggle;
    vm.showable = canShow;
    vm.collapse = collapse;

    notifications.emit('fetch', session.obtenerEmpleado());

    notifications.on('info', function(data) {
      addNewToCollection(data.data.payload);
      addToCollection(data.data.payload);
    });

    notifications.on('warn', function(data) {
      addNewToCollection(data.data.payload);
      addToCollection(data.data.payload);
    });

    notifications.on('error', function(data) {
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

    function deleteNotification(index, event) {
      if (vm.collection.length <= 1) { return; }
      var payload = {
        'user': session.obtenerEmpleado().usuario,
        'index': index
      };
      notifications.emit('delete', payload);
      vm.collection[index].wasDeleted = true;
      removeFromDOM(index);
    }

    function removeFromDOM(index) {
      $timeout(1000).then(function(){
        vm.collection.splice(index, 1);
      });
    }

    function toggle(channel) {
      if(channel === "info") {
        vm.showInfo = !vm.showInfo;
      } else if (channel === "warn") {
        vm.showWarn = !vm.showWarn;
      } else if (channel === "error") {
        vm.showError = !vm.showError;
      }
    }

    function canShow(item) {
      return  (item.channel == 'info' && vm.showInfo) ||
              (item.channel == 'warn' && vm.showWarn) ||
              (item.channel == 'error' && vm.showError);
    }

    function collapse() {
      vm.collapsed = !vm.collapsed;
    }
  }
})();
