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
        cliente: '=',
        form: '=',
        readOnly: '='
      },
      templateUrl: 'app/templates/components/domicilio.html'
    };
    return directive;

    function link(scope, element, attrs) {

    }
  }

  DomicilioController.$inject = ['CodigoPostal'];

  /* @ngInject */
  function DomicilioController(CodigoPostal) {

    var vm = this;
    vm.selectDomicilio = selectDomicilio;
    vm.selectTelefono = selectTelefono;
    vm.selectCp = selectCp;
    vm.selectTipo = selectTipo;
    vm.agregarDomicilio = agregarDomicilio;
    vm.agregarTelefono = agregarTelefono;
    vm.removerDomicilio = removerDomicilio;
    vm.removerTelefono = removerTelefono;
    vm.setUpdateDomicilio = setUpdateDomicilio;
    vm.setUpdateTelefono = setUpdateTelefono;
    vm.visible = visible;
    activate();

    /**
     * Definición de acciones para cada record en las colecciones.
     * Propiedad 'action' en cada objeto de domicilio o teléfono
     * 0 -> Crear nuevo
     * 1 -> Actualizar
     * 2 -> Eliminar
     * Cualquier otro -> No hacer nada
     */

    ///////////////////// Resources ///////////////////////////

    function activate() {
      vm.readOnly = vm.readOnly || false;
      vm.domicilios = vm.cliente.domicilios;
      vm.tipos = [{tipo: 'FIJO'}, {tipo: 'CELULAR'}, {tipo: 'FAX'}];

      getCodigosPostales().then(function(response) {
        return response;
      });
    }

    function getCodigosPostales() {
      return CodigoPostal.all()
        .then(function(codigosPostales) {
          vm.codigosPostales = codigosPostales;
          return vm.codigosPostales;
        });
    }

    /////////////////// UI Handling methods /////////////////////

    function selectDomicilio(domicilio) {
      vm.domicilio = domicilio;
      vm.telefono = ultimoSeleccionable(vm.domicilio.telefonos);
    }

    function selectTelefono(telefono) {
      vm.telefono = telefono;
    }

    function selectCp($item) {
      if ($item) {
        vm.domicilio.codigo_postal = $item.originalObject;
        vm.domicilio.codigo_postal_id = $item.originalObject.id;
      } else {
        vm.domicilio.codigo_postal = null;
        vm.domicilio.codigo_postal_id = null;
      }

      setUpdateDomicilio();
    }

    function selectTipo($item) {
      if ($item) {
        vm.telefono.tipo = $item.title;
      } else {
        vm.telefono.tipo = null;
      }

      setUpdateTelefono();
    }

    function agregarDomicilio() {
      if (!vm.domicilios) {
        vm.domicilios = [];
      }

      vm.domicilios.push({
        action: 0
      });
      vm.domicilio = ultimoSeleccionable(vm.domicilios);
      vm.telefono = vm.domicilio ? ultimoSeleccionable(vm.domicilio.telefonos) : null;
    }

    function agregarTelefono() {
      if (!vm.domicilio.telefonos) {
        vm.domicilio.telefonos = [];
      }

      vm.domicilio.telefonos.push({
        action: 0
      });
      vm.telefono = ultimoSeleccionable(vm.domicilio.telefonos);
    }

    function removerDomicilio() {
      if (vm.domicilio.action == 0) {
        var index = vm.domicilios.indexOf(vm.domicilio);
        vm.domicilios.splice(index, 1);
      } else {
        vm.domicilio.action = 2; // Acción eliminar
      }

      vm.domicilio = ultimoSeleccionable(vm.domicilios);
      vm.telefono = vm.domicilio ? ultimoSeleccionable(vm.domicilio.telefonos) : null;
      vm.form.$setDirty();
    }

    function removerTelefono() {
      if (vm.telefono.action == 0) {
        var index = vm.domicilio.telefonos.indexOf(vm.telefono);
        vm.domicilio.telefonos.splice(index, 1);
      } else {
        vm.telefono.action = 2; // Acción eliminar
      }

      vm.telefono = ultimoSeleccionable(vm.domicilio.telefonos);
      vm.form.$setDirty();
    }

    function setUpdateDomicilio() {
      if (!vm.domicilio.hasOwnProperty('action')) {
        vm.domicilio.action = 1; // Acción actualizar
      }

      vm.form.$setDirty();
    }

    function setUpdateTelefono() {
      if (!vm.telefono.hasOwnProperty('action')) {
        vm.telefono.action = 1; // Acción actualizar
      }

      vm.form.$setDirty();
    }

    ////////////////////// UTILS //////////////////////

    function visible(value) {
      if (!value.hasOwnProperty('action')) {
        return true;
      } else {
        return value.action != 2;
      }
    }

    function ultimoSeleccionable(array) {
      array = array || [];
      for (var i = array.length - 1; i >= 0; i--) {
        if (!array[i].hasOwnProperty('action')) {
          return array[i];
        } else {
          if (array[i].action != 2) {
            return array[i];
          }
        }
      }

      return null;
    }
  }

})();
