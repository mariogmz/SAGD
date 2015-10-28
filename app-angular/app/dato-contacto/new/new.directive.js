// app/dato-contacto/new/new.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.dato-contacto')
    .directive('newDatoContacto', newDatoContacto);

  newDatoContacto.$inject = [];

  /* @ngInject */
  function newDatoContacto() {
    // Usage:
    // <new-dato-contacto model="modelo-de-dato-contacto" form="variable-de-la-forma-padre"></new-dato-contacto>
    var directive = {
      bindToController: true,
      controller: newDatoContactoController,
      controllerAs: 'vm',
      restrict: 'E',
      scope: {
        datoContacto: '=model',
        form: '='
      },
      templateUrl: 'app/dato-contacto/new/new-dato-contacto.template.html'
    };
    return directive;
  }

  /* @ngInject */
  function newDatoContactoController() {
    var vm = this;

    vm.fields = [
      {
        type: 'input',
        key: 'email',
        templateOptions: {
          type: 'email',
          label: 'Correo electrónico:',
          placeholder: 'El correo electrónico del nuevo empleado',
          required: true
        }
      },
      {
        type: 'input',
        key: 'direccion',
        templateOptions: {
          type: 'text',
          label: 'Dirección:',
        }
      },
      {
        type: 'input',
        key: 'telefono',
        templateOptions: {
          type: 'text',
          label: 'Teléfono'
        }
      },
      {
        type: 'input',
        key: 'skype',
        templateOptions: {
          type: 'text',
          label: 'Skype'
        }
      }
    ];
  }
})();
