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
    public function index(Request $request)
    {
        $this->authorize($this);
        if ($request->has('revisados')) {
            $productos = $this->producto->whereHas('precios', function ($query) use ($request){
                $query->where('revisado', $request->revisados);
            })->get();
            return $productos;
        }else{
            return $this->producto->with('subfamilia')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
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
    public function show($id)
    {
        $this->authorize($this);
        $this->producto = $this->producto->with('tipoGarantia', 'marca', 'margen', 'unidad', 'subfamilia', 'dimension')->find($id);
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
    public function update(Request $request, $id)
    {
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
    public function destroy($id)
    {
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
    public function buscarUpc($upc)
    {
        $this->authorize($this);
        $this->producto = $this->producto->where('upc', $upc)->get();
        if ($this->producto->count() === 1) {
            return response()->json([
                'message' => 'Producto encontrado',
                'producto' => $this->producto->first()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Producto no encontrado',
                'error' => 'Producto no existente'
            ], 404);
        }
    }

    /**
     * Obtener las existencias en todas las sucursales del producto
     *
     * @param int $id
     * @return Response
     */
    public function indexExistencias($id)
    {
        $this->authorize($this);
        $this->producto = $this->producto->leftJoin('productos_sucursales', 'productos.id', '=', 'productos_sucursales.producto_id')
                ->join('sucursales', 'productos_sucursales.sucursal_id', '=', 'sucursales.id')
                ->join('existencias', 'productos_sucursales.id', '=', 'existencias.id')
                ->where('sucursales.proveedor_id', '1')
                ->where('productos.id', $id)
                ->get();
        if ($this->producto) {
            return response()->json([
                'message' => 'Productos con existencias obtenidas exitosamente',
                'productos' => $this->producto
            ], 200);
        } else {
            return response()->json([
                'message' => 'Producto no encontrado',
                'error' => 'Las existencias del producto que solicitaste no se encontraron.'
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
    public function pretransferir($id, Request $request)
    {
        $this->authorize($this);
        $this->producto = $this->producto->find($id);
        if ($this->producto) {
            $params = $request->all();
            $result = $this->producto->pretransferir($params);
            if (gettype($result) === 'boolean' && $result) {
                return response()->json([
                    'message' => 'Pretransferencias registradas exitosamente'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'La pretransferencia no se registro debido a un error interno. Las existencias no se modificaron',
                    'error' => $result->errors
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'La pretransferencia no se registro debido a que no se encontro el producto',
                'error' => 'Producto no encontrado'
            ], 404);
        }
    }
}
