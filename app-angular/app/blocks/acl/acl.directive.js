// app/blocks/acl/acl.directive.js

(function() {
  'use strict';

  angular
    .module('blocks.acl')
    .directive('acl', acl);

  acl.$inject = [];

  /* @ngInject */
  function acl() {
    // Usage:
    // <acl></acl>
    var directive = {
      bindToController: true,
      controller: Controller,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
      },
      templateUrl: 'app/templates/components/unauthorized.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  Controller.$inject = ['acl']

  /* @ngInject */
  function Controller(acl) {
    var vm = this;
    vm.acl = acl;
  }
})();
