// app/domicilio/edit/editDomicilio.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.domicilio')
    .directive('editDomicilio', editDomicilio);

  editDomicilio.$inject = [];

  /* @ngInject */
  function editDomicilio() {
    // Usage:
    // <edit-domicilio model="modelo-de-domicilio" form="variable-de-la-forma-padre"></edit-domicilio>
    var directive = {
      bindToController: true,
      controller: editDomicilioController,
      controllerAs: 'vm',
      restrict: 'E',
      scope: {
        domicilio: '=model',
        form: '=',
        telephone: '='
      },
      templateUrl: 'app/domicilio/edit/edit-domicilio.template.html'
    };
    return directive;
  }

  /* @ngInject */
  function editDomicilioController() {
    var vm = this;

    vm.fields = [
      {
        type: 'input',
        key: 'calle',
        templateOptions: {
          type: 'text',
          label: 'Calle:',
          required: true
        }
      },
      {
        type: 'input',
        key: 'localidad',
        templateOptions: {
          type: 'text',
          label: 'Localidad:',
          required: true
        }
      }
    ];

    vm.telephone = vm.telephone || false;
  }
})();
