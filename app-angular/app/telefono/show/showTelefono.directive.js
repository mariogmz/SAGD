// app/telefono/show/showTelefono.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.telefono')
    .directive('showTelefono', showTelefono);

  showTelefono.$inject = [];

  /* @ngInject */
  function showTelefono() {
    // Usage:
    // <show-telefono model="modelo-de-telefono"></show-telefono>
    var directive = {
      bindToController: true,
      controller: showTelefonoController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        telefono: '=model'
      },
      templateUrl: 'app/telefono/show/show-telefono.template.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  /* @ngInject */
  function showTelefonoController() {
    var vm = this;

    vm.fields = [
      {
        type: 'input',
        key: 'numero',
        templateOptions: {
          type: 'text',
          label: 'Numero:',
          disabled: true
        }
      }, {
        type: 'input',
        key: 'tipo',
        templateOptions: {
          type: 'text',
          label: 'Tipo:',
          disabled: true
        }
      }
    ];
  }
})();
