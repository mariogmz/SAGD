// app/icecat/categories/config.route.js

(function() {
  'use strict';

  angular
    .module('sagdApp.icecat')
    .config(configureRoutes);

  configureRoutes.$inject = ['$stateProvider'];

  function configureRoutes($stateProvider) {
    $stateProvider
      .state('icecatCategories', {
        url: '/categorias',
        parent: 'icecat',
        templateUrl: 'app/icecat/categories/categories.html',
        controller: 'icecatCategoriesController',
        controllerAs: 'vm'
      });
  }
})();
