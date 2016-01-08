(function() {
  'use strict';

  angular
    .module('sagdApp.sucursal')
    .factory('Sucursal', Sucursal);

  Sucursal.$inject = ['api', 'pnotify'];

  /* @ngInject */
  function Sucursal(api, pnotify) {
    var endpoint = '/sucursal';

    var service = {
      all: obtenerSucursales,
      create: crearSucursal,
      show: mostrarSucursal,
      update: actualizarSucursal,
      delete: eliminarSucursal,
      sucursalesProveedor: obtenerSucursalesDeProveedor
    };
    return service;

    ////////////////

    function obtenerSucursales() {
      return api.get(endpoint)
        .then(obtenerSucursalesComplete)
        .catch(obtenerSucursalesFailed);

      function obtenerSucursalesComplete(response) {
        return response.data;
      }

      function obtenerSucursalesFailed(error) {
        return error.data;
      }
    }

    function crearSucursal(data) {
      return api.post(endpoint, data)
        .then(crearSucursalComplete)
        .catch(crearSucursalFailed);

      function crearSucursalComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.sucursal;
      }

      function crearSucursalFailed(error) {
        pnotify.alertList(error.data.message, error.data, 'error');
      }
    }

    function mostrarSucursal(id) {
      return api.get(endpoint + '/', id)
        .then(mostrarSucursalComplete)
        .catch(mostrarSucursalFailed);

      function mostrarSucursalComplete(response) {
        console.log(response.data.message);
        return response.data.sucursal;
      }

      function mostrarSucursalFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarSucursal(id, data) {
      return api.put(endpoint + '/', id, data)
        .then(actualizarSucursalComplete)
        .catch(actualizarSucursalFailed);

      function actualizarSucursalComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data;
      }

      function actualizarSucursalFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function eliminarSucursal(id) {
      return api.delete(endpoint + '/', id)
        .then(eliminarSucursalComplete)
        .catch(eliminarSucursalFailed);

      function eliminarSucursalComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data;
      }

      function eliminarSucursalFailed(error) {
        pnotify.alert('Error', error.data.message, 'error');
      }
    }

    function obtenerSucursalesDeProveedor(claveProveedor) {
      return api.get(endpoint + '/proveedor/' + claveProveedor)
        .then(obtenerSucursalesDeProveedorComplete)
        .catch(obtenerSucursalesDeProveedorFailed);

      function obtenerSucursalesDeProveedorComplete(response) {
        return response.data;
      }

      function obtenerSucursalesDeProveedorFailed(error) {
        console.error(error.data);
      }
    }

  }

})();
