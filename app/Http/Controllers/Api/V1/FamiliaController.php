<?php

namespace App\Http\Controllers\Api\V1;


use App\Familia;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class FamiliaController extends Controller {

    protected $familia;

    public function __construct(Familia $familia) {
        $this->familia = $familia;
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
        return $this->familia->all();
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
        $this->familia->fill($params);
        if ($this->familia->save()) {
            return response()->json([
                'message' => 'Familia creada exitosamente',
                'familia' => $this->familia->self()
            ], 201,
                ['Location' => route('api.v1.familia.show', $this->familia->getId())]);
        } else {
            return response()->json([
                'message' => 'Familia no creada',
                'error'   => $this->familia->errors
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
        $this->familia = $this->familia->find($id);
        if ($this->familia) {
            return response()->json([
                'message' => 'Familia obtenida exitosamente',
                'familia' => $this->familia->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Familia no encontrada o no existente',
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
        $this->familia = $this->familia->find($id);
        if (empty($this->familia)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la familia',
                'error'   => 'Familia no encontrada'
            ], 404);
        } elseif ($this->familia->update($params)) {
            return response()->json([
                'message' => 'Familia se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la familia',
                'error'   => $this->familia->errors
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
        $this->familia = $this->familia->find($id);
        if (empty($this->familia)) {
            return response()->json([
                'message' => 'No se pudo eliminar la familia',
                'error'   => 'Familia no encontrada'
            ], 404);
        } elseif ($this->familia->delete()) {
            return response()->json([
                'message' => 'Familia eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la familia',
                'error'   => $this->familia->errors
            ], 400);
        }
    }
}
