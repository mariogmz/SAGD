<?php

namespace App\Http\Controllers\Api\V1;


use App\Precio;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class PrecioController extends Controller {

    protected $precio;

    public function __construct(Precio $precio) {
        $this->precio = $precio;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return $this->precio->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $params = $request->all();
        $this->precio->fill($params);
        if ($this->precio->save()) {
            return response()->json([
                'message' => 'Precio creado exitosamente',
                'precio' => $this->precio->self()
            ], 201,
                ['Location' => route('api.v1.precio.show', $this->precio->getId())]);
        } else {
            return response()->json([
                'message' => 'Precio no creado',
                'error'   => $this->precio->errors
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
        $this->precio = $this->precio->find($id);
        if ($this->precio) {
            return response()->json([
                'message' => 'Precio obtenido exitosamente',
                'precio' => $this->precio->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Precio no encontrado o no existente',
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
        $this->precio = $this->precio->find($id);
        if (empty($this->precio)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del precio',
                'error'   => 'Precio no encontrado'
            ], 404);
        } elseif ($this->precio->update($params)) {
            return response()->json([
                'message' => 'Precio se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del precio',
                'error'   => $this->precio->errors
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
        $this->precio = $this->precio->find($id);
        if (empty($this->precio)) {
            return response()->json([
                'message' => 'No se pudo eliminar el precio',
                'error'   => 'Precio no encontrado'
            ], 404);
        } elseif ($this->precio->delete()) {
            return response()->json([
                'message' => 'Precio eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el precio',
                'error'   => $this->precio->errors
            ], 400);
        }
    }
}
