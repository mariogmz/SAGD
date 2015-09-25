// app/producto/show/producto.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoShowController', ProductoShowController);

  ProductoShowController.$inject = ['$auth', '$state', '$stateParams', 'api'];

  function ProductoShowController($auth, $state, $stateParams, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

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
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:'
        }
      }, {
        type: 'input',
        key: 'familia_id',
        templateOptions: {
          type: 'text',
          label: 'Familia:'
        }
      }, {
        type: 'input',
        key: 'margen_id',
        templateOptions: {
          type: 'text',
          label: 'Margen:'
        }
      }
    ];
    initialize();

    function initialize(){
      return obtenerProducto().then(function (response){
        console.log(response.message);
      });
    }

    function obtenerProducto(){
      return api.get('/producto/', vm.id)
        .then(function (response){
          vm.producto = response.data.producto;
          return response.data;
        })
        .catch(function (response){
          vm.error = response.data;
          return response.data;
        });
    }

    function goBack() {
      window.history.back();
    }
  }
})();
