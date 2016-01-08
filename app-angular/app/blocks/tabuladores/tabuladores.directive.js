(function() {
  'use strict';

  angular
    .module('blocks.tabuladores')
    .directive('tabuladores', tabuladores);

  tabuladores.$inject = [];

  /* @ngInject */
  function tabuladores() {
    var directive = {
      bindToController: true,
      controller: TabuladoresController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        cliente: '=',
        form: '=',
        readOnly: '='
      },
      templateUrl: 'app/templates/components/tabuladores.html'
    };
    return directive;

    function link(scope, element, attrs) {

    }
  }

  TabuladoresController.$inject = [];

  /* @ngInject */
  function TabuladoresController() {
    var vm = this;

    activate();

    /////////////////////////

    function activate() {
      vm.cols = 4;
    }

  }

})();

