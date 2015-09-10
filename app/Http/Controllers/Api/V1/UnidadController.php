<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Unidad;
use Illuminate\Http\Request;

class UnidadController extends Controller {

    protected $unidad;

    public function __construct(Unidad $unidad) {
        $this->unidad = $unidad;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return $this->unidad->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $params = $request->all();
        $this->unidad->fill($params);
        if ($this->unidad->save()) {
            return response()->json([
                'message' => 'Unidad creada exitosamente',
                'unidad'  => $this->unidad->self()
            ], 201,
                ['Location' => route('api.v1.unidad.show', $this->unidad->getId())]);
        } else {
            return response()->json([
                'message' => 'Unidad no creada',
                'error'   => $this->unidad->errors
            ], 400
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        $this->unidad = $this->unidad->find($id);
        if ($this->unidad) {
            return response()->json([
                'message' => 'Unidad obtenida exitosamente',
                'unidad'  => $this->unidad->self()
            ], 200
            );
        } else {
            return response()->json([
                'message' => 'Unidad no encontrada o no existente',
                'error'   => 'No encontrada'
            ], 404
            );
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
        $this->unidad = $this->unidad->find($id);
        if (empty($this->unidad)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la unidad',
                'error'   => 'Unidad no encontrada'
            ], 404);
        } elseif ($this->unidad->update($params)) {
            return response()->json([
                'message' => 'Unidad se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la unidad',
                'error'   => $this->unidad->errors
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
        $this->unidad = $this->unidad->find($id);
        if (empty($this->unidad)) {
            return response()->json([
                'message' => 'No se pudo eliminar la unidad',
                'error'   => 'Unidad no encontrada'
            ], 404);
        } elseif ($this->unidad->delete()) {
            return response()->json([
                'message' => 'Unidad eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la unidad',
                'error'   => $this->unidad->errors
            ], 400);
        }
    }
}
