// app/resources/producto.resource.js
(function() {
  'use strict';

  angular
    .module('sagdApp.resources')
    .factory('Producto', Producto);

  Producto.$inject = ['api', 'pnotify'];

  /* @ngInject */
  function Producto(api, pnotify) {
    var endpoint = '/producto';
    var modelName = 'Producto';

    var resource = {
      all: obtenerProductos,
      create: crearProducto,
      show: mostrarProducto,
      update: actualizarProducto,
      delete: eliminarProducto,
      buscarUpc: buscarUpc,
      existencias: existencias,
      pretransferir: pretransferir,
      movimientos: movimientos,
      buscar: buscar,
      entradas: obtenerEntradas
    };
    return resource;

    //////////////////////////////////////////////////

    function obtenerProductos() {
      return api.get(endpoint)
        .then(obtenerComplete)
        .catch(obtenerFailed);

      function obtenerComplete(response) {
        return response.data;
      }

      function obtenerFailed(error) {
        console.error('No se pudo obtener el recurso ' + modelName + ' ' + error.data);
      }
    }

    function crearProducto(data) {
      return api.post(endpoint, data)
        .then(crearComplete)
        .catch(crearFailed);

      function crearComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data.producto;
      }

      function crearFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function mostrarProducto(id) {
      return api.get(endpoint + '/', id)
        .then(mostrarComplete)
        .catch(mostrarFailed);

      function mostrarComplete(response) {
        var producto = response.data.producto;
        producto.precios = response.data.precios_proveedor;
        producto = formatProductoPrecios(producto);
        return producto;
      }

      function mostrarFailed(error) {
        console.error(error.data.message);
      }
    }

    function actualizarProducto(id, data) {
      return api.put(endpoint + '/', id, data)
        .then(actualizarComplete)
        .catch(actualizarFailed);

      function actualizarComplete(response) {
        pnotify.alert('¡Exito!', response.data.message, 'success');
        return response.data;
      }

      function actualizarFailed(error) {
        pnotify.alertList(error.data.message, error.data.error, 'error');
      }
    }

    function eliminarProducto(id) {
      return api.delete(endpoint + '/', id)
        .then(eliminarComplete)
        .catch(eliminarFailed);

      function eliminarComplete(response) {
        console.log(response.data.message);
        return response.data;
      }

      function eliminarFailed(error) {
        console.error(error.data.error);
      }
    }

    function buscarUpc(upc) {
      return api.get(endpoint + '/buscar/' + upc)
        .then(buscarUpcComplete)
        .catch(buscarUpcFailed);

      function buscarUpcComplete(response) {
        console.log(response.data.message);
        return response.data.producto;
      }

      function buscarUpcFailed(error) {
        console.error(error.data.message);
      }
    }

    function existencias(id) {
      return api.get(endpoint + '/' + id + '/existencias/')
        .then(existenciasComplete)
        .catch(existenciasFailed);

      function existenciasComplete(response) {
        return response.data.productos;
      }

      function existenciasFailed(error) {
        console.error(error.data.message);
      }
    }

    function pretransferir(id, data) {
      return api.post(endpoint + '/' + id + '/existencias/pretransferir', data)
        .then(pretransferirComplete)
        .catch(pretransferirFailed);

      function pretransferirComplete(response) {
        pnotify.alert('Exito', response.data.message, 'success');
        return response.data;
      }

      function pretransferirFailed(error) {
        pnotify.alert(error.data.error, error.data.message, 'error');
      }
    }

    function movimientos(id, sucursalId) {
      var sucursal = sucursalId ? sucursalId : JSON.parse(localStorage.getItem('empleado')).sucursal_id;
      return api.get(endpoint + '/' + id + '/movimientos/sucursal/' + sucursal)
        .then(movimientosComplete)
        .catch(movimientosFailed);

      function movimientosComplete(response) {
        console.log(response.data.message);
        return response.data.productos;
      }

      function movimientosFailed(error) {
        console.error(error.data.message);
      }
    }

    function buscar(clave, descripcion, numeroParte, upc) {
      var searchParameters = {
        clave: clave || '',
        descripcion: descripcion || '',
        numero_parte: numeroParte || '',
        upc: upc || ''
      };
      return api.get(endpoint + 's/buscar/', searchParameters)
        .then(buscarComplete)
        .catch(buscarFailed);

      function buscarComplete(response) {
        return response.data;
      }

      function buscarFailed(error) {
        pnotify.alert(response.data.error, response.data.message, 'error');
      }
    }

    function obtenerEntradas(id) {
      return api.get(endpoint + '/' + id + '/entradas')
        .then(obtenerEntradasComplete)
        .catch(obtenerEntradasFailed);

      function obtenerEntradasComplete(response) {
        console.log(response.data.message);
        return response.data.entradas;
      }

      function obtenerEntradasFailed(error) {
        console.error(error.data.error);
      }
    }

    //////////////////////// UTILS /////////////////////////

    function formatProductoPrecios(producto) {
      producto.revisado = true;
      producto.precios.forEach(function(precio) {
        producto.revisado = producto.revisado && precio.revisado;
        precio.descuento *= 100;
      });

      return producto;
    }

  }

})();

