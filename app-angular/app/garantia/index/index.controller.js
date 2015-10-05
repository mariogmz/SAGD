// app/garantia/index/index.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.garantia')
    .controller('garantiaIndexController', garantiaIndexController);

  garantiaIndexController.$inject = ['$auth', '$state', 'api', 'pnotify', 'modal'];

  /* @ngInject */
  function garantiaIndexController($auth, $state, api, pnotify, modal) {
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.garantias = [];
    vm.sort = sort;
    vm.eliminarGarantia = eliminar;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Descripción', key: 'descripcion'},
      {name: 'Días', key: 'dias'},
      {name: 'Seriado', key: 'seriado'},
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerGarantias().then(function(){
        console.log('Garantias obtenidas');
      });
    }

    function obtenerGarantias() {
      return api.get('/tipo-garantia')
        .then(function(response){
          vm.garantias = response.data;
          return vm.garantias;
        });
    }

    function eliminar(garantia) {
      modal.confirm({
        title: 'Eliminar Tipo de Garantia',
        content: 'Estas a punto de eliminar un tipo de Garantia. ¿Estás seguro?',
        accept: 'Eliminar',
        isDanger: true
      })
      .then(function(response) {
        modal.hide('confirm');
        eliminarGarantia(garantia.id);
      })
      .catch(function(response) {
        modal.hide('confirm');
        return false;
      });
    }

    function eliminarGarantia(id) {
      return api.delete('/tipo-garantia/', id)
        .then(function(response){
          obtenerGarantias()
            .then(function(){
              pnotify.alert('Exito', response.data.message, 'success');
            });
        })
        .catch(function(response){
          pnotify.alert('Error', response.data.message, 'error');
        });
    }

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }
})();
