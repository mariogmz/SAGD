<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\TipoGarantia;
use Illuminate\Http\Request;

class TipoGarantiaController extends Controller {

    protected $tipoGarantia;

    public function __construct(TipoGarantia $tipoGarantia) {
        $this->tipoGarantia = $tipoGarantia;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return $this->tipoGarantia->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $params = $request->all();
        $this->tipoGarantia = $this->tipoGarantia->fill($params);
        if ($this->tipoGarantia->save()) {
            return response()->json([
                'message'      => 'TipoGarantia creado exitosamente',
                'tipoGarantia' => $this->tipoGarantia->self()
            ], 201);
        } else {
            return response()->json([
                'message' => 'TipoGarantia no creado',
                'error'   => $this->tipoGarantia->errors
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
        $this->tipoGarantia = $this->tipoGarantia->find($id);
        if ($this->tipoGarantia) {
            return response()->json([
                'message'      => 'TipoGarantia obtenido exitosamente',
                'tipoGarantia' => $this->tipoGarantia->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'TipoGarantia no encontrado o no existente',
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
        $this->tipoGarantia = $this->tipoGarantia->find($id);
        if (empty($this->tipoGarantia)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del tipo de garantia',
                'error'   => 'TipoGarantia no encontrado'
            ], 404);
        } elseif ($this->tipoGarantia->update($params)) {
            return response()->json([
                'message' => 'TipoGarantia se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del tipo de garantia',
                'error'   => $this->tipoGarantia->errors
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
        $this->tipoGarantia = $this->tipoGarantia->find($id);
        if (empty($this->tipoGarantia)) {
            return response()->json([
                'message' => 'No se pudo eliminar el tipo de garantia',
                'error'   => 'TipoGarantia no encontrado o no existente'
            ], 404);
        } elseif ($this->tipoGarantia->delete()) {
            return response()->json([
                'message' => 'TipoGarantia eliminado exitosamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el tipo de garantia',
                'error'   => $this->tipoGarantia->errors
            ], 400);
        }
    }
}
