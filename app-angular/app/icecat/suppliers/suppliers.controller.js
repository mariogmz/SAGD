// app/icecat/suppliers/suppliers.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.icecat')
    .controller('icecatSuppliersController', IcecatSuppliersController);

  IcecatSuppliersController.$inject = ['api', 'utils', 'pnotify'];

  function IcecatSuppliersController(api, utils, pnotify) {
    var vm = this;
    vm.obtenerMarcas = obtenerMarcas;
    vm.obtenerSuppliers = obtenerSuppliers;
    vm.seleccionarMarca = seleccionarMarca;
    vm.asociarFabricante = asociarFabricante;
    vm.desasociarFabricante = desasociarFabricante;

    initialize();

    function initialize() {
      vm.marcas = {
        label: 'Marcas internas'
      };
      vm.suppliers = {
        label: 'Fabricantes de Icecat®'
      };
      vm.suppliersConMarcas = {
        label: 'Fabricantes relacionados'
      };

      vm.marca = {};
      vm.supplier = {};
      vm.relacionado = {};
    }

    function obtenerMarcas(name) {
      return api.get('/marca/nombre/' + name)
        .then(function(response) {
          vm.marcas = {
            label: 'Marcas internas',
            elements: response.data.map(function(marca) {
              marca.name = marca.nombre;
              delete marca.nombre;
              return marca;
            })
          };
          console.log('Se han obtenido las marcas correctamente');
        }).catch(function(response) {
          console.error('No se pudieron obtener las marcas');
        });
    }

    function obtenerSuppliers(name) {
      if (name) {
        return api.get('/icecat/supplier/name/' + name)
          .then(function(response) {
            vm.suppliers.elements = response.data;
            vm.suppliersSet = vm.suppliers.elements;
            removeMatches();
            console.log('Se han obtenido los fabricantes correctamente');
          }).catch(function(response) {
            console.error('No se pudieron obtener los fabricantes');
          });
      }
    }

    function seleccionarMarca(marca) {
      return api.get('/icecat/supplier/marca_id/' + marca.id)
        .then(function(response) {
          vm.suppliersConMarcas.elements = response.data;
          removeMatches();

          console.log('Fabricantes relacionados a marca ' + marca.name + ' obtenidos correctamente');
        }).catch(function(response) {
          console.error('No se pudieron obtener los fabricantes');
        });
    }

    function asociarFabricante(supplier) {
      return api.put('/icecat/supplier/', supplier.id, {marca_id: vm.marca.id})
        .then(function(response) {
          var index = vm.suppliers.elements.indexOf(supplier);
          vm.suppliers.elements.splice(index, 1);
          vm.suppliersConMarcas.elements.push(supplier);

          console.log(response.data.message);
        }).catch(function(response) {
          console.error(response.data.error);
          pnotify.alert(response.data.message, response.data.error, 'error');
        });
    }

    function desasociarFabricante(supplier) {
      return api.put('/icecat/supplier/', supplier.id, {marca_id: null})
        .then(function(response) {
          var index = vm.suppliersConMarcas.elements.indexOf(supplier);
          vm.suppliersConMarcas.elements.splice(index, 1);
          removeMatches();

          console.log(response.data.message);
        }).catch(function(response) {
          console.error(response.data.error);
          pnotify.alert(response.data.message, response.data.error, 'error');
        });
    }

    function removeMatches() {
      if (vm.suppliersConMarcas.elements) {
        if (vm.suppliersSet && vm.suppliersConMarcas.elements.length > 0) {
          var ids = utils.pluck(vm.suppliersConMarcas.elements, 'id');
          vm.suppliers.elements = vm.suppliersSet.filter(function(supplier) {
            return ids.indexOf(supplier.id) == -1;
          });
        }
      }
    }
  }

})();
