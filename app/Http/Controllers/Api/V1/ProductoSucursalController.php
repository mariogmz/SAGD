<?php

namespace App\Http\Controllers\Api\V1;


use App\ProductoSucursal;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class ProductoSucursalController extends Controller {

    protected $producto_sucursal;

    public function __construct(ProductoSucursal $producto_sucursal) {
        $this->producto = $producto_sucursal;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize($this);
        return $this->producto->all();
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
        $this->producto->fill($params);
        if ($this->producto->save()) {
            return response()->json([
                'message' => 'Producto asociado a sucursal exitosamente',
                'producto' => $this->producto->self()
            ], 201,
                ['Location' => route('api.v1.producto.show', $this->producto->getId())]);
        } else {
            return response()->json([
                'message' => 'Producto no asociado a sucursal',
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
        $this->producto = $this->producto->find($id);
        if ($this->producto) {
            return response()->json([
                'message' => 'Asociación producto-sucursal obtenida exitosamente',
                'producto' => $this->producto->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Asociación producto-sucursal no encontrada',
                'error'   => 'No encontrada'
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
                'message' => 'No se pudo actualizar la relación producto-sucursal',
                'error'   => 'ProductoSucursal no encontrado'
            ], 404);
        } elseif ($this->producto->update($params)) {
            return response()->json([
                'message' => 'Asociación de producto-sucursal actualizada correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo actualizar la relación producto-sucursal',
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
                'message' => 'No se pudo eliminar la relación producto-sucursal',
                'error'   => 'ProductoSucursal no encontrado'
            ], 404);
        } elseif ($this->producto->delete()) {
            return response()->json([
                'message' => 'Relación producto-sucursal eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la relación producto-sucursal',
                'error'   => $this->producto->errors
            ], 400);
        }
    }
}
