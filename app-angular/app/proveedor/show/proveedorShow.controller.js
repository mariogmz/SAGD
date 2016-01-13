// app/proveedor/show/proveedor.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.proveedor')
    .controller('proveedorShowController', ProveedorShowController);

  ProveedorShowController.$inject = ['$stateParams', 'api'];

  /* @ngInject */
  function ProveedorShowController($stateParams, api) {

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:'
        }
      }, {
        type: 'input',
        key: 'razon_social',
        templateOptions: {
          type: 'text',
          label: 'Razón social:'
        }
      }, {
        type: 'input',
        key: 'pagina_web',
        templateOptions: {
          type: 'text',
          label: 'Página web:'
        }
      }, {
        type: 'select',
        key: 'externo',
        templateOptions: {
          label: '¿Es Externo?',
          options: [
            {value: 0, name: "No"},
            {value: 1, name: "Si"}
          ]
        }
      }
    ];
    initialize();

    function initialize() {
      return obtenerProveedor().then(function(response) {
        console.log(response.message);
      });
    }

    function obtenerProveedor() {
      return api.get('/proveedor/', vm.id)
        .then(function(response) {
          vm.proveedor = response.data.proveedor;
          return response.data;
        })
        .catch(function(response) {
          vm.error = response.data;
          return response.data;
        });
    }

    function goBack() {
      window.history.back();
    }
  }

})
();
