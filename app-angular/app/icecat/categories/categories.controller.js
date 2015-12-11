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
    vm.obtenerCategories = obtenerCategories;
    vm.seleccionarSubfamilia = seleccionarSubfamilia;
    vm.asociarCategoria = asociarCategoria;
    vm.desasociarCategoria = desasociarCategoria;

    initialize();

    function initialize() {
      vm.subfamilias = {
        label: 'Subfamilias internas'
      };
      vm.categories = {
        label: 'Categorias de Icecat®'
      };
      vm.categoriesConSubfamilias = {
        label: 'Categorias relacionados'
      };

      vm.subfamilia = {};
      vm.category = {};
      vm.relacionado = {};
    }

    function obtenerSubfamilias(name) {
      return api.get('/subfamilia/nombre/' + name)
        .then(function(response) {
          vm.subfamilias = {
            label: 'Subfamilias internas',
            elements: response.data.map(function(subfamilia) {
              subfamilia.name = subfamilia.nombre;
              delete subfamilia.nombre;
              return subfamilia;
            })
          };
          console.log('Se han obtenido las subfamilias correctamente');
        }).catch(function(response) {
          console.error('No se pudieron obtener las subfamilias');
        });
    }

    function obtenerCategories(name) {
      if (name) {
        return api.get('/icecat/category/name/' + name)
          .then(function(response) {
            vm.categories.elements = response.data;
            vm.categoriesSet = vm.categories.elements;
            removeMatches();
            console.log('Se han obtenido los fabricantes correctamente');
          }).catch(function(response) {
            console.error('No se pudieron obtener los fabricantes');
          });
      }
    }

    function seleccionarSubfamilia(subfamilia) {
      return api.get('/icecat/category/subfamilia_id/' + subfamilia.id)
        .then(function(response) {
          vm.categoriesConSubfamilias.elements = response.data;
          removeMatches();

          console.log('Categorias relacionados a subfamilia ' + subfamilia.name + ' obtenidos correctamente');
        }).catch(function(response) {
          console.error('No se pudieron obtener los fabricantes');
        });
    }

    function asociarCategoria(category) {
      return api.put('/icecat/category/', category.id, {subfamilia_id: vm.subfamilia.id})
        .then(function(response) {
          var index = vm.categories.elements.indexOf(category);
          vm.categories.elements.splice(index, 1);
          vm.categoriesConSubfamilias.elements.push(category);

          console.log(response.data.message);
        }).catch(function(response) {
          console.error(response.data.error);
          pnotify.alert(response.data.message, response.data.error, 'error');
        });
    }

    function desasociarCategoria(category) {
      return api.put('/icecat/category/', category.id, {subfamilia_id: null})
        .then(function(response) {
          var index = vm.categoriesConSubfamilias.elements.indexOf(category);
          vm.categoriesConSubfamilias.elements.splice(index, 1);
          removeMatches();

          console.log(response.data.message);
        }).catch(function(response) {
          console.error(response.data.error);
          pnotify.alert(response.data.message, response.data.error, 'error');
        });
    }

    function removeMatches() {
      if (vm.categoriesSet && vm.categoriesConSubfamilias.elements.length > 0) {
        var ids = utils.pluck(vm.categoriesConSubfamilias.elements, 'id');
        vm.categories.elements = vm.categoriesSet.filter(function(category) {
          return ids.indexOf(category.id) == -1;
        });
      }
    }
  }

})();
