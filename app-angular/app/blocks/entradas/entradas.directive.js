// app/blocks/entradas/entradas.directive.js
(function() {
  'use strict';

  angular.module('blocks.entradas')
    .directive('entradas', entradas);

  entradas.$inject = [];

  /* @ngInject */
  function entradas() {
    var directive = {
      bindToController: true,
      controller: EntradasController,
      controllerAs: 'vm',
      link: link,
      scope: {
        productoId: '='
      },
      templateUrl: 'app/templates/components/entradas.html'
    };

    return directive;

    function link(scope, element, attrs) {

    }
  }

  EntradasController.$inject = [];

  /* @ngInject */
  function EntradasController() {
    var vm = this;

    activate();

    //////////////////////////////

    function activate() {

    }
  }
})();
