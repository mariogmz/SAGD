// app/subfamilia/index/margenIndex.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .controller('subfamiliaIndexController', SubfamiliaIndexController);

  SubfamiliaIndexController.$inject = ['$auth', '$state', 'api', 'pnotify', 'modal'];

  function SubfamiliaIndexController($auth, $state, api, pnotify, modal){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sort = sort;
    vm.eliminarSubfamilia = eliminar;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Nombre', key: 'nombre'},
      {name: 'Familia', key: 'familia.clave'},
      {name: 'Margen', key: 'margen.clave'}
    ];

    initialize();

    function initialize(){
      return obtenerSubfamilias().then(function (){
        console.log("Subfamilias obtenidas");
      });
    }

    function obtenerSubfamilias(){
      return api.get('/subfamilia')
        .then(function (response){
          vm.subfamilias = response.data;
          return vm.subfamilias;
        });
    }

    function eliminar(subfamilia) {
       modal.confirm({
        title: 'Eliminar Subfamilia',
        content: 'Estas a punto de eliminar la subfamilia ' + subfamilia.nombre + '. ¿Estás seguro?',
        accept: 'Eliminar Subfamilia',
        type: 'danger'
      })
      .then(function(response) {
        modal.hide('confirm');
        eliminarSubfamilia(subfamilia.id);
      })
      .catch(function(response) {
        modal.hide('confirm');
        return false;
      });
    }

    function eliminarSubfamilia(id){
      return api.delete('/subfamilia/', id)
        .then(function (response){
          obtenerSubfamilias().then(function (){
            pnotify.alert('¡Exito!', response.data.message, 'success');
          });
        }).catch(function (response){
          pnotify.alert('¡Error!', response.data.message, 'error');
        });
    }

    function sort(keyname){
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }

  }

})();
