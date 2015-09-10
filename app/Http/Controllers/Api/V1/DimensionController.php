<?php

namespace App\Http\Controllers\Api\V1;


use App\Dimension;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class DimensionController extends Controller {

    protected $dimension;

    public function __construct(Dimension $dimension) {
        $this->dimension = $dimension;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return $this->dimension->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $params = $request->all();
        $this->dimension->fill($params);
        if ($this->dimension->save()) {
            return response()->json([
                'message'   => 'Dimension creada exitosamente',
                'dimension' => $this->dimension->self()
            ], 201,
                ['Location' => route('api.v1.dimension.show', $this->dimension->getId())]);
        } else {
            return response()->json([
                'message' => 'Dimension no creada',
                'error'   => $this->dimension->errors
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
        $this->dimension = $this->dimension->find($id);
        if ($this->dimension) {
            return response()->json([
                'message'   => 'Dimension obtenida exitosamente',
                'dimension' => $this->dimension->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Dimension no encontrada o no existente',
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
    public function update(Request $request, $id) {
        $params = $request->all();
        $this->dimension = $this->dimension->find($id);
        if (empty($this->dimension)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la dimension',
                'error'   => 'Dimension no encontrada'
            ], 404);
        } elseif ($this->dimension->update($params)) {
            return response()->json([
                'message' => 'Dimension se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la dimension',
                'error'   => $this->dimension->errors
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
        $this->dimension = $this->dimension->find($id);
        if (empty($this->dimension)) {
            return response()->json([
                'message' => 'No se pudo eliminar la dimension',
                'error'   => 'Dimension no encontrada o no existente'
            ], 404);
        } elseif ($this->dimension->delete()) {
            return response()->json([
                'message' => 'Dimension eliminada exitosamente',

            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la dimension',
                'error'   => $this->dimension->errors
            ], 400);
        }
    }
}
