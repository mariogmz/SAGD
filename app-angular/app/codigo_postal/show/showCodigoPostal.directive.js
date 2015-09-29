// app/codigo_postal/show/showCodigoPostal.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.codigo-postal')
    .directive('showCodigoPostal', showCodigoPostal);

  showCodigoPostal.$inject = [];

  /* @ngInject */
  function showCodigoPostal() {
    // Usage:
    // <show-codigo-postal model="modelo-de-codigo-postal"></show-codigo-postal>
    var directive = {
      bindToController: true,
      controller: showCodigoPostalController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        codigo_postal: '=model'
      },
      templateUrl: 'app/codigo_postal/show/show-codigo-postal.template.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  /* @ngInject */
  function showCodigoPostalController() {
    var vm = this;

    vm.fields = [
      {
        type: 'input',
        key: 'municipio',
        templateOptions: {
          type: 'text',
          label: 'Municipio:'
        }
      },
      {
        type: 'input',
        key: 'estado',
        templateOptions: {
          type: 'text',
          label: 'Estado:'
        }
      },
      {
        type: 'input',
        key: 'codigo_postal',
        templateOptions: {
          type: 'text',
          label: 'CP:'
        }
      }
    ];
  }
})();
