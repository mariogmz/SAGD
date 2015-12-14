// app/icecat/categories/categories.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.icecat')
    .controller('icecatCategoriesController', IcecatCategoriesController);

  IcecatCategoriesController.$inject = ['api', 'utils', 'pnotify'];

  function IcecatCategoriesController(api, utils, pnotify) {
    var vm = this;
    vm.obtenerSubfamilias = obtenerSubfamilias;
    vm.obtenerCategorias = obtenerCategorias;
    vm.seleccionarSubfamilia = seleccionarSubfamilia;
    vm.asociarCategoria = asociarCategoria;
    vm.desasociarCategoria = desasociarCategoria;

    initialize();

    function initialize() {
      vm.subfamilias = {
        label: 'Subfamilias internas'
      };
      vm.categorias = {
        label: 'Categorias de Icecat®'
      };
      vm.categoriasConSubfamilias = {
        label: 'Categorias relacionadas'
      };

      vm.subfamilia = {};
      vm.categoria = {};
      vm.relacionado = {};
    }

    function obtenerSubfamilias(name) {
      return api.get('/subfamilia/nombre/' + name)
        .then(function(response) {
          vm.subfamilias.elements = response.data.map(function(subfamilia) {
            subfamilia.name = subfamilia.nombre;
            delete subfamilia.nombre;
            return subfamilia;
          });

          console.log('Se han obtenido las subfamilias correctamente');
        }).catch(function(response) {
          console.error('No se pudieron obtener las subfamilias');
        });
    }

    function obtenerCategorias(name) {
      if (name) {
        return api.get('/icecat/category/name/' + name)
          .then(function(response) {
            vm.categorias.elements = response.data;
            vm.categoriasSet = vm.categorias.elements;
            removeMatches();
            console.log('Se han obtenido las categorías correctamente');
          }).catch(function(response) {
            console.error('No se pudieron obtener las categorías');
          });
      }
    }

    function seleccionarSubfamilia(subfamilia) {
      return api.get('/icecat/category/subfamilia_id/' + subfamilia.id)
        .then(function(response) {
          vm.categoriasConSubfamilias.elements = response.data;
          removeMatches();

          console.log('Categorias relacionados a subfamilia ' + subfamilia.name + ' obtenidos correctamente');
        }).catch(function(response) {
          console.error('No se pudieron obtener las categorías');
        });
    }

    function asociarCategoria(categoria) {
      return api.put('/icecat/category/', categoria.id, {subfamilia_id: vm.subfamilia.id})
        .then(function(response) {
          var index = vm.categorias.elements.indexOf(categoria);
          vm.categorias.elements.splice(index, 1);
          vm.categoriasConSubfamilias.elements.push(categoria);

          console.log(response.data.message);
        }).catch(function(response) {
          console.error(response.data.error);
          pnotify.alert(response.data.message, response.data.error, 'error');
        });
    }

    function desasociarCategoria(categoria) {
      return api.put('/icecat/category/', categoria.id, {subfamilia_id: null})
        .then(function(response) {
          var index = vm.categoriasConSubfamilias.elements.indexOf(categoria);
          vm.categoriasConSubfamilias.elements.splice(index, 1);
          removeMatches();

          console.log(response.data.message);
        }).catch(function(response) {
          console.error(response.data.error);
          pnotify.alert(response.data.message, response.data.error, 'error');
        });
    }

    function removeMatches() {
      if (vm.categoriasSet && vm.categoriasConSubfamilias.elements.length > 0) {
        var ids = utils.pluck(vm.categoriasConSubfamilias.elements, 'id');
        vm.categorias.elements = vm.categoriasSet.filter(function(categoria) {
          return ids.indexOf(categoria.id) == -1;
        });
      }
    }
  }

})();
