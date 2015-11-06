// app/revisar-precios/show/revisarPrecios.controller.js

(function (){

  'use strict';

  angular
    .module('sagdApp.revisarPrecios')
    .controller('revisarPreciosController', RevisarPreciosController);

  RevisarPreciosController.$inject = ['api', 'pnotify'];

  function RevisarPreciosController(api, pnotify){

    var vm = this;
    vm.sortKeys = [
      {name: '#', key: 'id'},
      {name: 'Clave', key: 'clave'},
      {name: 'UPC', key: 'upc'},
      {name: 'Num. Parte', key: 'numero_parte'},
      {name: 'Descripción', key: 'descripcion'}
    ];

    vm.preciosSortKeys = [
      {name: 'Proveedor', key: 'clave'},
      {name: 'Costo', key: 'costo'},
      {name: 'P1', key: 'precio_1'},
      {name: 'P2', key: 'precio_2'},
      {name: 'P3', key: 'precio_3'},
      {name: 'P4', key: 'precio_4'},
      {name: 'P5', key: 'precio_5'},
      {name: 'P6', key: 'precio_6'},
      {name: 'P7', key: 'precio_7'},
      {name: 'P8', key: 'precio_8'},
      {name: 'P9', key: 'precio_9'},
      {name: 'P10', key: 'precio_10'},
      {name: 'Dcto%', key: 'descuento'}
    ];

    vm.sort = sort;
    vm.revisar = revisar;
    vm.calcularPreciosMargen = calcularPreciosMargen;
    vm.calcularPrecios = calcularPrecios;
    vm.revisarSiguiente = revisarSiguiente;

    initialize();

    function initialize(){
      return obtenerProductosNoRevisados()
        .then(obtenerMargenes)
        .then(function (){
          console.log('Productos obtenidos correctamente.');
          $state.go('revisarPreciosIndex');
        });
    }

    function obtenerProductosNoRevisados(){
      return api.get('/producto/', [{key: 'revisados', value: false}])
        .then(function (response){
          vm.productos = response.data;
          return response.data;
        })
        .catch(function (response){
          console.log('Hubo un error al obtener los productos.')
        });
    }

    function obtenerProducto(){
      return api.get('/producto/', vm.id)
        .then(function (response){
          vm.producto = response.data.producto;
          vm.producto.precios = response.data.precios_proveedor;
          vm.producto.revisado = true;
          vm.producto.precios.forEach(function (precio){
            vm.producto.revisado = vm.producto.revisado && precio.revisado;
            precio.descuento *= 100;
          });
          return response;
        }).catch(function (response){
          console.log(response.data);
        });
    }

    function obtenerMargenes(){
      return api.get('/margen').then(function (response){
        vm.margenes = response.data;
        console.log('Margenes obtenidos correctamente');
      });
    }

    function guardarProducto(){
      vm.producto.revisado = true;
      vm.producto.precios.forEach(function (precio){
        precio.descuento /= 100;
      });
      return api.put('/producto/', vm.id, vm.producto)
        .then(function (response){
          vm.message = response.data.message;
          pnotify.alert('Exito', vm.message, 'success');
          return response;
        })
        .catch(function (response){
          vm.error = response.data;
          pnotify.alertList('No se pudo guardar el producto', vm.error.error, 'error');
          return response;
        });
    }

    function calcularPrecios(index){
      var params = [
        {key: 'precio', value: vm.producto.precios[index].precio_1},
        {key: 'costo', value: vm.producto.precios[index].costo},
        {key: 'margen_id', value: vm.producto.margen_id},
        {key: 'externo', value: vm.producto.precios[index].externo}
      ];
      return api.get('/calcular-precio', params)
        .then(function (response){
          console.log(response.data.message);
          for (var attr in response.data.resultado.precios) {
            vm.producto.precios[index][attr] = response.data.resultado.precios[attr];
          }
          vm.utilidad = response.data.resultado.utilidades;

        }).catch(function (response){
          pnotify.alertList(response.data.message, response.data.error, 'error');
        });
    }

    function calcularPreciosMargen(){
      var cantidadProveedores = vm.producto.precios.length;
      for (var i = 0; i < cantidadProveedores; i++) {
        calcularPrecios(i);
      }
    }

    function revisar(index){
      vm.index = index;
      vm.id = vm.productos[index].id;
      return obtenerProducto()
        .then(function (){
          $state.go('revisarPreciosEdit');
        });
    }

    function revisarSiguiente(){
      return guardarProducto()
        .then(function (response){
          vm.productos.splice(vm.index, 1);
          if (vm.productos[vm.index - 1] ||  vm.productos[vm.index]) {
            vm.index = vm.productos[vm.index] ? vm.index : vm.index -1;
            vm.id = vm.productos[vm.index].id;
            obtenerProducto();
          } else {
            pnotify.alert('Precios Revisados', 'No quedan precios pendientes por revisar', 'info');
            $state.go('productoIndex');
          }
        })
    }

    function sort(keyname){
      vm.sortKey = keyname;
      vm.reverse = !vm.reverse;
    }
  }
})();
