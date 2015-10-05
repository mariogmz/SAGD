// app/familia/index/margenIndex.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.familia')
    .controller('familiaIndexController', FamiliaIndexController);

  FamiliaIndexController.$inject = ['$auth', '$state', 'api', 'pnotify', 'modal'];

  function FamiliaIndexController($auth, $state, api, pnotify, modal){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.sort = sort;
    vm.eliminarFamilia = eliminar;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Nombre', key: 'nombre'}
    ];

    initialize();

    function initialize(){
      return obtenerFamilias().then(function (){
        console.log("Familias obtenidas");
      });
    }

    function obtenerFamilias(){
      return api.get('/familia')
        .then(function (response){
          vm.familias = response.data;
          return vm.familias;
        });
    }

    function eliminar(familia) {
      modal.confirm({
        title: 'Eliminar Familia',
        content: 'Estas a punto de eliminar una familia. ¿Estás seguro?',
        accept: 'Eliminar Familia',
        type: 'danger'
      })
      .then(function(response) {
        modal.hide('confirm');
        eliminarFamilia(familia.id);
      })
      .catch(function(response) {
        modal.hide('confirm');
        return false;
      });
    }

    function eliminarFamilia(id){
      return api.delete('/familia/', id)
        .then(function (response){
          obtenerFamilias().then(function(){
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
