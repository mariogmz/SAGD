(function() {
  'use strict';

  angular
    .module('blocks.domicilio')
    .directive('domicilio', domicilio);

  domicilio.$inject = [];

  /* @ngInject */
  function domicilio() {
    var directive = {
      bindToController: true,
      controller: DomicilioController,
      controllerAs: 'vm',
      link: link,
      restrict: 'E',
      scope: {
        cliente: '='
      },
      templateUrl: 'app/templates/components/domicilio.html'
    };
    return directive;

    function link(scope, element, attrs) {

    }
  }

  DomicilioController.$inject = ['Domicilio', 'CodigoPostal'];

  /* @ngInject */
  function DomicilioController(Domicilio, CodigoPostal) {

    var vm = this;
    vm.selectDomicilio = selectDomicilio;
    vm.selectCp = selectCp;
    activate();

    ////////////////////////

    function activate() {
      vm.domicilios = vm.cliente.domicilios;
      vm.tipos = [{tipo: 'FIJO'}, {tipo: 'CELULAR'}, {tipo: 'FAX'}];
      getCodigosPostales().then(function(response) {
        return response;
      });
    }

    function selectDomicilio(domicilio) {
      vm.domicilio = domicilio;
    }

    function getCodigosPostales() {
      return CodigoPostal.all()
        .then(function(codigosPostales) {
          vm.codigosPostales = codigosPostales;
          return vm.codigosPostales;
        });
    }

    function selectCp($item) {
      if ($item) {
        vm.domicilios[this.$parent.$index].codigoPostal = {
          estado: $item.originalObject.estado,
          municipio: $item.originalObject.municipio
        };
      } else {
        vm.domicilios[this.$parent.$index].codigoPostal = null;
      }
    }
  }

})();

