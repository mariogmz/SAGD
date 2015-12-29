// app/telefono/edit/editTelefono.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.telefono')
    .directive('editTelefono', editTelefono);

  editTelefono.$inject = [];

  /* @ngInject */
  function editTelefono() {
    // Usage:
    // <edit-telefono model="modelo-de-telefono"></edit-codigo-postal>
    var directive = {
      bindToController: true,
      controller: editTelefonoController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        telefono: '=model'
      },
      templateUrl: 'app/telefono/edit/edit-telefono.template.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  /* @ngInject */
  function editTelefonoController() {
    var vm = this;

    vm.fields = [
      {
        type: 'input',
        key: 'numero',
        templateOptions: {
          type: 'text',
          label: 'Numero:',
          placeholder: 'Sólo números sin espacios en blanco ni guiones',
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
