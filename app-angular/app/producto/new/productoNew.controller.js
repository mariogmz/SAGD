// app/producto/producto.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.producto')
    .controller('productoNewController', ProductoNewController);

  ProductoNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function ProductoNewController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.back = goBack;

    vm.create = create;

    function create(){
      api.post('/producto', vm.producto)
        .then(function (response){
          pnotify.alert('¡Exito!', response.data.message, 'success');
          $state.go('productoShow', {id: response.data.producto.id});
        })
        .catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function goBack(){
      window.history.back();
    }
  }

})();
