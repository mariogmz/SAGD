// app/icecat/index/index.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.icecat')
    .controller('icecatIndexController', IcecatIndexController);

  IcecatIndexController.$inject = [];

  /* ngInject */
  function IcecatIndexController() {
    var vm = this;

    initialize();

    function initialize() {
      vm.indexElements = [
        {label: 'Fabricantes', state: 'icecatSuppliers', picUrl: '', icon: 'industry'},
        {label: 'Categorías', state: 'icecatCategories', picUrl: '', icon: 'object-group'},
        {label: 'Características', state: 'icecatFeatures', picUrl: '', icon: 'tag'},
        {label: 'Tareas', state: 'icecatTasks', picUrl: '', icon: 'tasks'}
      ];
    }
  }

})();
