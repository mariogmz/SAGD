<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller {

    protected $producto;

    public function __construct(Producto $producto) {
        $this->producto = $producto;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $this->authorize($this);
        if ($request->has('revisados')) {
            $productos = $this->producto->whereHas('precios', function ($query) use ($request) {
                $query->where('revisado', $request->revisados);
            })->get();

            return $productos;
        } else {
            return $this->producto->with('subfamilia')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $this->authorize($this);
        $params = $request->all();
        $this->producto->fill($params['producto']);
        if ($this->producto->guardarNuevo($params)) {
            return response()->json([
                'message'  => 'Producto creado exitosamente',
                'producto' => $this->producto->self()
            ], 201,
                ['Location' => route('api.v1.producto.show', $this->producto->getId())]);
        } else {
            return response()->json([
                'message' => 'Producto no creado',
                'error'   => $this->producto->errors
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        $this->authorize($this);
        $this->producto = $this->producto->with('tipoGarantia', 'marca', 'margen', 'unidad', 'subfamilia', 'dimension', 'ficha')->find($id);
        if ($this->producto) {
            return response()->json([
                'message'           => 'Producto obtenido exitosamente',
                'producto'          => $this->producto->self(),
                'precios_proveedor' => $this->producto->preciosProveedor()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Producto no encontrado o no existente',
                'error'   => 'No encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $this->authorize($this);
        $params = $request->all();
        $this->producto = $this->producto->find($id);
        if (empty($this->producto)) {

            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del producto',
                'error'   => 'Producto no encontrado'
            ], 404);

        } elseif ($this->producto->actualizar($params)) {
            return response()->json([
                'message' => 'Producto se actualizo correctamente'
            ], 200);

        } else {

            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del producto',
                'error'   => $this->producto->errors
            ], 400);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        $this->authorize($this);
        $this->producto = $this->producto->find($id);
        if (empty($this->producto)) {
            return response()->json([
                'message' => 'No se pudo eliminar el producto',
                'error'   => 'Producto no encontrado'
            ], 404);
        } elseif ($this->producto->delete()) {
            return response()->json([
                'message' => 'Producto eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el producto',
                'error'   => $this->producto->errors
            ], 400);
        }
    }

    /**
     * Buscar un producto por su UPC
     *
     * @param string $upc
     * @return Response
     */
    public function buscarUpc($upc) {
        $this->authorize($this);
        $this->producto = $this->producto->where('upc', $upc)->get();
        if ($this->producto->count() === 1) {
            return response()->json([
                'message'  => 'Producto encontrado',
                'producto' => $this->producto->first()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Producto no encontrado',
                'error'   => 'Producto no existente'
            ], 404);
        }
    }

    /**
     * Obtener las existencias en todas las sucursales del producto
     *
     * @param int $id
     * @return Response
     */
    public function indexExistencias($id) {
        $this->authorize($this);
        $this->producto = $this->producto->leftJoin('productos_sucursales', 'productos.id', '=', 'productos_sucursales.producto_id')
            ->join('sucursales', 'productos_sucursales.sucursal_id', '=', 'sucursales.id')
            ->join('existencias', 'productos_sucursales.id', '=', 'existencias.id')
            ->where('sucursales.proveedor_id', '1')
            ->where('productos.id', $id)
            ->get();
        if ($this->producto) {
            return response()->json([
                'message'   => 'Productos con existencias obtenidas exitosamente',
                'productos' => $this->producto
            ], 200);
        } else {
            return response()->json([
                'message' => 'Las existencias del producto que solicitaste no se encontraron.',
                'error'   => 'Producto no encontrado'
            ], 404);
        }
    }

    /**
     * Llama la funcion para pretransferir las existencias del producto en base
     * a los parametros enviados
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function pretransferir($id, Request $request) {
        $this->authorize($this);
        $this->producto = $this->producto->find($id);
        if ($this->producto) {
            $params = $request->all();
            if ($this->producto->pretransferir($params)) {
                return response()->json([
                    'message' => 'Pretransferencias registradas exitosamente'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'La pretransferencia no se registro debido a un error interno. Las existencias no se modificaron',
                    'error'   => 'Pretransferencia fallo'
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'La pretransferencia no se registro debido a que no se encontro el producto',
                'error'   => 'Producto no encontrado'
            ], 404);
        }
    }

    /**
     * Obtiene el listado de los movimientos de un producto filtrados por sucursal
     * @param int $id
     * @param int $sucursal
     * @return Response
     */
    public function indexMovimientos($id, $sucursal) {
        $this->authorize($this);
        $this->producto = $this->producto
            ->select('productos_movimientos.*')
            ->join('productos_sucursales', 'productos.id', '=', 'productos_sucursales.producto_id')
            ->join('productos_movimientos', 'productos_movimientos.producto_sucursal_id', '=', 'productos_sucursales.id')
            ->where('productos.id', $id)
            ->where('productos_sucursales.sucursal_id', $sucursal)
            ->orderBy('productos_movimientos.created_at', 'desc')
            ->get();
        if ($this->producto) {
            return response()->json([
                'message'   => 'Productos con movimientos obtenidos exitosamente',
                'productos' => $this->producto
            ], 200);
        } else {
            return response()->json([
                'message' => 'Los movimientos del producto que solicitaste no se encontraron.',
                'error'   => 'Producto no encontrado'
            ], 404);
        }
    }

    /**
     * Permite la busqueda de productos a traves de 3 paramtros
     * @param Request $request
     * @return Response
     */
    public function buscar(Request $request) {
        $this->authorize($this);
        $params = $request->only('clave', 'descripcion', 'numero_parte', 'upc');

        $params['clave'] = isset($params['clave']) ? $params['clave'] : '*';
        $params['descripcion'] = isset($params['descripcion']) ? $params['descripcion'] : '*';
        $params['numero_parte'] = isset($params['numero_parte']) ? $params['numero_parte'] : '*';
        $params['upc'] = isset($params['upc']) ? $params['upc'] : '*';

        if (
            $params['clave'] === '*' &&
            $params['descripcion'] === '*' &&
            $params['numero_parte'] === '*' &&
            $params['upc'] === '*'
        ) {
            return response()->json([
                'message' => 'Debes de especificar al menos un valor de busqueda',
                'error'   => 'Busqueda muy larga'
            ], 400);
        }
        foreach ($params as $column => $search) {
            if ($search === '*') {
                continue;
            }
            $this->producto = $this->producto->where($column, 'like', "%{$search}%");
        }

        return $this->producto->get();
    }

    /**
     * Obtiene las entradas relacionadas a un producto en específico
     * @param $id
     * @return Response
     */
    public function entradas($id) {
        $this->authorize($this);
        $this->producto = $this->producto->find($id);
        if ($this->producto) {
            $entradas = $this->producto->entradasDetalles()->groupBy('entrada_id')->with('entrada')->get();

            return response()->json([
                'message'  => 'Entradas obtenidas correctamente.',
                'entradas' => $entradas
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudieron obtener las entradas.',
                'error'   => 'Producto no encontrado.'
            ], 404);
        }
    }
}
