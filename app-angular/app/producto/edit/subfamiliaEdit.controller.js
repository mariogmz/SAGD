// app/producto/producto.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoEditController', ProductoEditController);

  ProductoEditController.$inject = ['$auth', '$state', '$stateParams', 'api', 'pnotify'];

  function ProductoEditController($auth, $state, $stateParams, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.save = guardarProducto;
    vm.back = goBack;

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          required: true
        }
      }, {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          required: true
        }
      }
    ];

    initialize();

    function initialize(){
      return obtenerProducto('/producto/', vm.id).then(function (response){
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

    function guardarProducto(){
      return api.put('/producto/', vm.id, vm.producto)
        .then(function (response){
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          return response;
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar el producto', vm.error.error, 'error');
          return response;
        });
    }

    function goBack() {
      window.history.back();
    }
  }

})();
