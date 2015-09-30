// app/codigo_postal/new/newCodigoPostal.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.codigo-postal')
    .directive('newCodigoPostal', newCodigoPostal);

  newCodigoPostal.$inject = [];

  /* @ngInject */
  function newCodigoPostal() {
    // Usage:
    // <new-codigo-postal model="modelo-de-codigo-postal"></new-codigo-postal>
    var directive = {
      bindToController: true,
      controller: newCodigoPostalController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        codigo_postal: '=model'
      },
      templateUrl: 'app/codigo_postal/new/new-codigo-postal.template.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  /* @ngInject */
  function newCodigoPostalController() {
    var vm = this;

    vm.fields = [
      {
        type: 'input',
        key: 'codigo_postal',
        templateOptions: {
          type: 'text',
          label: 'CP:',
          required: true
        }
      }
    ];
  }
})();
