// app/subfamilia/subfamilia.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.subfamilia')
    .controller('subfamiliaNewController', SubfamiliaNewController);

  SubfamiliaNewController.$inject = ['$auth', '$state', 'api', 'pnotify'];

  function SubfamiliaNewController($auth, $state, api, pnotify){
    if (!$auth.isAuthenticated()) {
      $state.go('login', {});
    }

    var vm = this;
    vm.fields = [
      {
        type: 'input',
        key: 'clave',
        templateOptions: {
          type: 'text',
          label: 'Clave:',
          required: true,
          placeholder: 'Máximo 4 caracteres alfanuméricos'
        }
      }, {
        type: 'input',
        key: 'nombre',
        templateOptions: {
          type: 'text',
          label: 'Nombre:',
          required: true,
          placeholder: 'Máximo 45 caracteres'
        }
      }, {
        type: 'select',
        key: 'familia_id',
        templateOptions: {
          label: 'Familia:',
          required: true,
          options: [],
          ngOptions: 'familia.id as familia.nombre for familia in to.options'
        },
        controller: /*@ngInject*/ function ($scope){
          $scope.to.loading = api.get('/familia').then(function (response){
            $scope.to.options = response.data;
            return response;
          });
        }
      }, {
        type: 'select',
        key: 'margen_id',
        templateOptions: {
          label: 'Margen:',
          options: [],
          ngOptions: 'margen.id as margen.nombre for margen in to.options'
        },
        controller: /*@ngInject*/ function ($scope){
          $scope.to.loading = api.get('/margen').then(function (response){
            $scope.to.options = response.data;
            return response;
          });
        }
      }
    ];

    vm.create = create;

    function create(){
      api.post('/subfamilia', vm.subfamilia)
        .then(function (response){
          pnotify.alert('¡Exito!', response.data.message, 'success');
          $state.go('subfamiliaShow', {id: response.data.subfamilia.id});
        })
        .catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

  }

})();
