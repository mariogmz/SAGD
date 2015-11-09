// app/unidad/index/index.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.unidad')
    .controller('unidadIndexController', unidadIndexController);

  unidadIndexController.$inject = ['api', 'pnotify', 'modal'];

  /* @ngInject */
  function unidadIndexController(api, pnotify, modal) {

    var vm = this;
    vm.sort = sort;
    vm.eliminarUnidad = eliminar;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Nombre', key: 'nombre'},
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerUnidades().then(function (){
        console.log('Unidades obtenidas');
      });
    }

    function obtenerUnidades(){
      return api.get('/unidad')
        .then(function(response){
          vm.unidades = response.data;
          return vm.unidades;
        });
    }

    function eliminar(sucursal) {
      modal.confirm({
        title: 'Eliminar Unidad',
        content: 'Estas a punto de eliminar una unidad. ¿Estás seguro?',
        accept: 'Eliminar Unidad',
        type: 'danger'
      })
      .then(function(response) {
        modal.hide('confirm');
        eliminarUnidad(sucursal.id);
      })
      .catch(function(response) {
        modal.hide('confirm');
        return false;
      })
    }

    function eliminarUnidad(id) {
      return api.delete('/unidad/', id)
        .then(function(response){
          obtenerUnidades().then(function() {
            pnotify.alert('¡Éxito!', response.data.message, 'success');
          });
        })
        .catch(function(response){
          pnotify.alert('¡Error!', response.data.message, 'error');
        });
    }

    function sort(keyname){
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }
})();
