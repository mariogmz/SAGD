(function() {
  'use strict';

  angular
    .module('sagdApp.icecat')
    .controller('icecatFeaturesShowController', IcecatFeaturesShowController);

  IcecatFeaturesShowController.$inject = ['$stateParams', 'api'];

  /* @ngInject */
  function IcecatFeaturesShowController($stateParams, api) {
    var vm = this;
    vm.back = goBack;

    initialize();

    ////////////////

    function initialize() {
      vm.id = $stateParams.id;
      vm.fields = [
        {
          type: 'input',
          key: 'id',
          templateOptions: {
            type: 'text',
            label: 'ID:'
          }
        }, {
          type: 'input',
          key: 'icecat_id',
          templateOptions: {
            type: 'text',
            label: 'Icecat® ID:'
          }
        }, {
          type: 'input',
          key: 'name',
          templateOptions: {
            type: 'text',
            label: 'Nombre:'
          }
        }, {
          type: 'input',
          key: 'type',
          templateOptions: {
            type: 'text',
            label: 'Tipo:'
          }
        }, {
          type: 'input',
          key: 'measure',
          templateOptions: {
            type: 'text',
            label: 'Unidad de medida:'
          }
        }, {
          type: 'textarea',
          key: 'description',
          templateOptions: {
            label: 'Descripción'
          }
        }
      ];
      obtenerFeature();
    }

    function obtenerFeature() {
      return api.get('/icecat/feature/', vm.id)
        .then(function(response) {
          vm.feature = response.data.feature;
          console.log(response.data.message);
        }).catch(function(response) {
          console.error(response.data.error);
        });
    }

    function goBack() {
      window.history.back();
    }
  }

})();

