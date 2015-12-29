// app/telefono/new/newTelefono.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.telefono')
    .directive('newTelefono', newTelefono);

  newTelefono.$inject = [];

  /* @ngInject */
  function newTelefono() {
    // Usage:
    // <new-telefono model="modelo-de-telefono"></new-codigo-postal>
    var directive = {
      bindToController: true,
      controller: newTelefonoController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        telefono: '=model'
      },
      templateUrl: 'app/telefono/new/new-telefono.template.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  /* @ngInject */
  function newTelefonoController() {
    var vm = this;

    vm.fields = [
      {
        type: 'input',
        key: 'numero',
        templateOptions: {
          type: 'text',
          label: 'Numero:',
          placeholder: 'Sólo números sin espacios en blanco ni guiones',
          pattern: '/[1-9]{1,12}/',
          maxlength: 12
        }
      }, {
        type: 'input',
        key: 'tipo',
        templateOptions: {
          type: 'text',
          label: 'Tipo:',
          maxlength: 45
        }
      }
    ];
  }
})();
