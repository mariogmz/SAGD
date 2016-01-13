// app/rol/index/index.controller.js

(function() {
  'use strict';

  angular
    .module('sagdApp.rol')
    .controller('rolIndexController', rolIndexController);

  rolIndexController.$inject = ['api', 'pnotify', 'modal'];

  /* @ngInject */
  function rolIndexController(api, pnotify, modal) {

    var vm = this;
    vm.sort = sort;
    vm.eliminarRol = eliminar;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'Nombre', key: 'nombre'},
    ];

    activate();

    ////////////////

    function activate() {
      return obtenerRoles().then(function() {
        console.log('Roles obtenidas');
      });
    }

    function obtenerRoles() {
      return api.get('/rol')
        .then(function(response) {
          vm.roles = response.data;
          return vm.roles;
        });
    }

    function eliminar(sucursal) {
      modal.confirm({
          title: 'Eliminar Rol',
          content: 'Estas a punto de eliminar una rol. ¿Estás seguro?',
          accept: 'Eliminar Rol',
          type: 'danger'
        })
        .then(function(response) {
          modal.hide('confirm');
          eliminarRol(sucursal.id);
        })
        .catch(function(response) {
          modal.hide('confirm');
          return false;
        })
    }

    function eliminarRol(id) {
      return api.delete('/rol/', id)
        .then(function(response) {
          obtenerRoles().then(function() {
            pnotify.alert('¡Éxito!', response.data.message, 'success');
          });
        })
        .catch(function(response) {
          pnotify.alert('¡Error!', response.data.message, 'error');
        });
    }

    function sort(keyname) {
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }
})();
