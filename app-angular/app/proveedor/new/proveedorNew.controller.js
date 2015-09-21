// app/proveedor/proveedorNew.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.proveedor')
    .controller('proveedorNewController', ProveedorNewController);

  ProveedorNewController.$inject = ['$auth', '$state', '$stateParams', 'api', 'pnotify'];

  function ProveedorNewController($auth, $state, $stateParams, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;

    vm.onSubmit = onSubmit;
    vm.model = {};

    vm.fields = [
      {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          required: true
        },
        validators: {
          notEquals: '$viewValue != "Prov"'
        }
      }
    ];

    function onSubmit(){
      //alert(JSON.stringify(vm.model), null, 2);

      return api.put('/proveedor/', vm.id, vm.model)
      .then(function (response){
            vm.message = response.data.message;
            pnotify.alert('Exito', vm.message, 'success');
            return response;
          })
          .catch(function (response){
            vm.error = response.data;
            pnotify.alertList('No se pudo guardar el proveedor', vm.error.error, 'error');
            return response;
         });
    }

  }

})();
