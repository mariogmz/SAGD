// app/domicilio/show/showDomicilio.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.domicilio')
    .directive('showDomicilio', showDomicilio);

  showDomicilio.$inject = [];

  /* @ngInject */
  function showDomicilio() {
    // Usage:
    // <show-domicilio model="modelo-de-domicilio"></show-domicilio>
    var directive = {
      bindToController: true,
      controller: showDomicilioController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        domicilio: '=model'
      },
      templateUrl: 'app/domicilio/show/show-domicilio.template.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  /* @ngInject */
  function showDomicilioController() {
    var vm = this;

    vm.fields = [
      {
        type: 'input',
        key: 'calle',
        templateOptions: {
          type: 'text',
          label: 'Calle:'
        }
      }
    ];
  }
})();
