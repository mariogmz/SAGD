// app/proveedor/proveedorNew.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.proveedor')
    .controller('proveedorNewController', ProveedorNewController);

  ProveedorNewController.$inject = ['$state', 'api', 'pnotify'];

  function ProveedorNewController($state, api, pnotify){

    var vm = this;

    vm.onSubmit = onSubmit;
    vm.model = {};

    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          label: 'Clave:',
          placeholder: 'Introduzca la clave',
          required: true
        },
        validators: {
          notEquals: '$viewValue != "Prov"'
        }
      }, {
        type: 'input',
        key: 'razon_social',
        templateOptions: {
          label: 'Razón social',
          placeholder: 'Introduzca la razón social',
          required: true
        }
      }, {
        type: 'input',
        key: 'pagina_web',
        templateOptions: {
          label: 'Sitio Web'
        }
      }, {
        type: 'select',
        key: 'externo',
        templateOptions: {
          label: '¿Es Externo?',
          options: [
            {value: 0, name: "No"},
            {value: 1, name: "Si"}
          ]
        }
      }

    ];

    function onSubmit(){
      return api.post('/proveedor', vm.model)
        .then(function (response){
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          $state.go('proveedorShow', {id: response.data.proveedor.id});
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar el proveedor', vm.error.error, 'error');
          return response;
        });
    }

  }

})();
