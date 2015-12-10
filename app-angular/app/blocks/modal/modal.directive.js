// app/blocks/modal/modal.directive.js

(function() {
  'use strict';

  angular
    .module('blocks.modal')
    .directive('modal', modal);

  modal.$inject = [];

  /* @ngInject */
  function modal() {
    // Usage:
    //
    var directive = {
      bindToController: true,
      controller: modalController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
      },
      templateUrl: 'app/templates/components/modal.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  /* @ngInject */
  function modalController() {
    var vm = this;
    vm.modal_password = '';
    vm.emptyPassword = emptyPassword;

    function emptyPassword() {
      return vm.modal_password.length < 7;
    }
  }
})();
