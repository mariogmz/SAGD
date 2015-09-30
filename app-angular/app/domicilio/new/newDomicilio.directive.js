// app/domicilio/new/newDomicilio.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.domicilio')
    .directive('newDomicilio', newDomicilio);

  newDomicilio.$inject = [];

  /* @ngInject */
  function newDomicilio() {
    // Usage:
    // <new-domicilio model="modelo-de-domicilio" form="variable-de-la-forma-padre"></new-domicilio>
    var directive = {
      bindToController: true,
      controller: newDomicilioController,
      controllerAs: 'vm',
      restrict: 'E',
      scope: {
        domicilio: '=model',
        form: '='
      },
      templateUrl: 'app/domicilio/new/new-domicilio.template.html'
    };
    return directive;
  }

  /* @ngInject */
  function newDomicilioController() {
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
  }
})();
