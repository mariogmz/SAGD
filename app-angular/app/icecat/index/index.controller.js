// app/icecat/index/index.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.icecat')
    .controller('icecatIndexController', IcecatIndexController);

  IcecatIndexController.$inject = [];

  function IcecatIndexController() {
    var vm = this;

    initialize();

    function initialize() {
      vm.indexElements = [
        {label: 'Fabricantes', state: 'icecatSuppliersIndex', picUrl: 'https://avatars0.githubusercontent.com/u/139426?v=3&s=400'},
        {label: 'Categorías', state: 'icecatCategoriesIndex', picUrl: 'https://avatars0.githubusercontent.com/u/139426?v=3&s=400'},
        {label: 'Características', state: 'icecatFeaturesIndex', picUrl: 'https://avatars0.githubusercontent.com/u/139426?v=3&s=400'},        {label: 'Fabricantes', state: 'icecatSuppliersIndex', picUrl: 'https://avatars0.githubusercontent.com/u/139426?v=3&s=400'},
        {label: 'Categorías', state: 'icecatCategoriesIndex', picUrl: 'https://avatars0.githubusercontent.com/u/139426?v=3&s=400'},
        {label: 'Características', state: 'icecatFeaturesIndex', picUrl: 'https://avatars0.githubusercontent.com/u/139426?v=3&s=400'},
        {label: 'Tareas', state: 'icecatTasksIndex', picUrl: 'https://avatars0.githubusercontent.com/u/139426?v=3&s=400'}
      ];
    }
  }

})();
