(function() {
  'use strict';

  angular
    .module('sagdApp.icecat')
    .controller('icecatFeaturesController', IcecatFeaturesController);

  IcecatFeaturesController.$inject = ['api'];

  /* @ngInject */
  function IcecatFeaturesController(api) {
    var vm = this;
    vm.obtenerFeatures = obtenerFeatures;
    vm.sort = sort;

    initialize();

    ////////////////

    function initialize() {
      vm.sortKeys = [
        {name: 'Icecat® ID', key: 'icecat_id'},
        {name: 'Nombre', key: 'icecat_id'},
        {name: 'Tipo', key: 'type'},
        {name: 'Unidad de medida', key: 'measure'}
      ];
      vm.loading = false;
    }

    function obtenerFeatures() {
      vm.loading = true;
      return api.get('/icecat/feature/name/', vm.search)
        .then(function(response) {
          vm.features = response.data;
          console.log('Se han obtenido las características correctamente.');
        }).catch(function(response) {
          console.log('No se han podido obtener las características.');
        })
        .then(function() {
          vm.loading = false;
        });
    }

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }

})();

