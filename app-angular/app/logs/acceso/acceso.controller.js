// app/logs/acceso/acceso.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.logs')
    .controller('logsAccesoController', logsAccesoController);

  logsAccesoController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function logsAccesoController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sort = sort;

    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Usuario', key: 'empleado.usuario'},
      {name: 'Fecha', key: 'created_at'},
      {name: 'Exitoso', key: 'exitoso'}
    ];

    initialize();

    function initialize(){
      return obtenerLogs().then(function (){
        console.log("Logs de acceso obtenidos");
      });
    }

    function obtenerLogs(){
      return api.get('/logs-acceso')
        .then(function (response){
          vm.logs = response.data;
          return vm.logs;
        });
    }

    function sort(keyname){
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }
})();
