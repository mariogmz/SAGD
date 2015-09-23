<?php

namespace App\Http\Controllers\Api\V1;


use App\Subfamilia;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class SubfamiliaController extends Controller {

    protected $subfamilia;

    public function __construct(Subfamilia $subfamilia) {
        $this->subfamilia = $subfamilia;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return $this->subfamilia->with('familia','margen')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $params = $request->all();
        $this->subfamilia->fill($params);
        if ($this->subfamilia->save()) {
            return response()->json([
                'message' => 'Subfamilia creada exitosamente',
                'subfamilia' => $this->subfamilia->self()
            ], 201,
                ['Location' => route('api.v1.subfamilia.show', $this->subfamilia->getId())]);
        } else {
            return response()->json([
                'message' => 'Subfamilia no creada',
                'error'   => $this->subfamilia->errors
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
        $this->subfamilia = $this->subfamilia->find($id);
        if ($this->subfamilia) {
            return response()->json([
                'message' => 'Subfamilia obtenida exitosamente',
                'subfamilia' => $this->subfamilia->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Subfamilia no encontrada o no existente',
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
        $this->subfamilia = $this->subfamilia->find($id);
        if (empty($this->subfamilia)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la subfamilia',
                'error'   => 'Subfamilia no encontrada'
            ], 404);
        } elseif ($this->subfamilia->update($params)) {
            return response()->json([
                'message' => 'Subfamilia se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la subfamilia',
                'error'   => $this->subfamilia->errors
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
        $this->subfamilia = $this->subfamilia->find($id);
        if (empty($this->subfamilia)) {
            return response()->json([
                'message' => 'No se pudo eliminar la subfamilia',
                'error'   => 'Subfamilia no encontrada'
            ], 404);
        } elseif ($this->subfamilia->delete()) {
            return response()->json([
                'message' => 'Subfamilia eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la subfamilia',
                'error'   => $this->subfamilia->errors
            ], 400);
        }
    }
}
