// app/cliente/show/cliente.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.cliente')
    .controller('clienteShowController', ClienteShowController)
    .controller('tabController', TabController);

  ClienteShowController.$inject = ['$auth', '$state', '$stateParams', 'api'];
  TabController.$inject = [];

  function ClienteShowController($auth, $state, $stateParams, api){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.id = $stateParams.id;
    vm.back = goBack;


    initialize();

    function initialize(){
      return obtenerCliente().then(function (response){
        console.log(response.message);
      });
    }

    function obtenerCliente(){
      return api.get('/cliente/', vm.id)
        .then(function (response){
          vm.cliente = response.data.cliente;
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

  function TabController(){
    console.log("Tab");
  }

})
();
