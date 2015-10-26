// app/dato-contacto/show/show.directive.js

(function() {
  'use strict';

  angular
    .module('sagdApp.dato-contacto')
    .directive('showDatoContacto', showDatoContacto);

  showDatoContacto.$inject = [];

  /* @ngInject */
  function showDatoContacto() {
    // Usage:
    // <show-dato-contacto model="modelo-de-dato-contacto"></show-dato-contacto>
    var directive = {
      bindToController: true,
      controller: showDatoContactoController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        datoContacto: '=model'
      },
      templateUrl: 'app/dato-contacto/show/show-dato-contacto.template.html'
    };
    return directive;

    function link(scope, element, attrs) {
    }
  }

  /* @ngInject */
  function showDatoContactoController() {
    var vm = this;

    vm.fields = [
      {
        type: 'input',
        key: 'email',
        templateOptions: {
          type: 'email',
          label: 'Correo electrónico:',
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
