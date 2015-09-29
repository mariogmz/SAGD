// app/codigo_postal/edit/editCodigoPostal.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.codigo-postal')
    .directive('editCodigoPostal', editCodigoPostal);

  editCodigoPostal.$inject = [];

  /* @ngInject */
  function editCodigoPostal() {
    // Usage:
    // <edit-codigo-postal model="modelo-de-codigo-postal"></edit-codigo-postal>
    var directive = {
      bindToController: true,
      controller: editCodigoPostalController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        codigo_postal: '=model'
      },
      templateUrl: 'app/codigo_postal/edit/edit-codigo-postal.template.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  /* @ngInject */
  function editCodigoPostalController() {
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
