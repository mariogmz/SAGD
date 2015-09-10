<?php

namespace App\Http\Controllers\Api\V1;


use App\Producto;
use App\Http\Controllers\Controller;
use App\Http\Requests;
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
    public function index() {
        return $this->producto->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $params = $request->all();
        $this->producto->fill($params);
        if ($this->producto->save()) {
            return response()->json([
                'message' => 'Producto creado exitosamente',
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
        $this->producto = $this->producto->find($id);
        if ($this->producto) {
            return response()->json([
                'message' => 'Producto obtenido exitosamente',
                'producto' => $this->producto->self()
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
        $params = $request->all();
        $this->producto = $this->producto->find($id);
        if (empty($this->producto)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del producto',
                'error'   => 'Producto no encontrado'
            ], 404);
        } elseif ($this->producto->update($params)) {
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
}
