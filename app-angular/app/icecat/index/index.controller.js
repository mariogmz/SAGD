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
        {label: 'Fabricantes', state: 'icecatSuppliers', picUrl: '', icon: 'industry'},
        {label: 'Categorías', state: 'icecatCategoriesIndex', picUrl: '', icon: 'object-group'},
        {label: 'Características', state: 'icecatFeaturesIndex', picUrl: '', icon: 'tag'},
        {label: 'Tareas', state: 'icecatTasksIndex', picUrl: '', icon: 'tasks'}
      ];
    }
  }

})();
