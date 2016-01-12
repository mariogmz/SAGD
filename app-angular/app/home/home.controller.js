// app/home/home.controller.js

(function() {

  'use strict';

  angular
    .module('sagdApp.home')
    .controller('HomeController', HomeController);

  HomeController.$inject = [];

  function HomeController() {
    var vm = this;

    activate();

    //////////////////////////////

    function activate() {
      vm.elements = [
        {label: 'Productos', state: 'productoIndex', picUrl: '', icon: 'laptop'},
        {label: 'Inventario', state: 'inventario', picUrl: '', icon: 'list'},
        {label: 'Clientes', state: 'clienteIndex', picUrl: '', icon: 'users'},
        {label: 'Vender', state: 'venta.vender', picUrl: '', icon: 'shopping-cart'},
        {label: 'Cajas y cortes', state: 'cajaIndex', picUrl: '', icon: 'money'},
        {label: 'Paqueterías', state: 'paqueteria', picUrl: '', icon: 'truck'},
        {label: 'Empleados', state: 'empleadoIndex', picUrl: '', icon: 'user'},
        {label: 'Sucursales', state: 'sucursalIndex', picUrl: '', icon: 'building'},
        {label: 'Facturación', state: 'facturacionIndex', picUrl: '', icon: 'file-text'}
      ];
      vm.empleado = JSON.parse(localStorage.getItem('empleado'));
    }
  }
})();
