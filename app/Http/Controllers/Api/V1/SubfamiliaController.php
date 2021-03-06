<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Subfamilia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubfamiliaController extends Controller {

    protected $subfamilia;

    public function __construct(Subfamilia $subfamilia) {
        $this->subfamilia = $subfamilia;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $campo
     * @param mixed $valor
     * @return Response
     */
    public function index($campo = null, $valor = null) {
        $this->authorize($this);
        if (isset($campo) && isset($valor)) {
            $valor = str_replace(' ', '%', $valor);

            return $this->subfamilia->where($campo, 'LIKE', "%{$valor}%")->get();
        } else {
            return $this->subfamilia->with('familia', 'margen')->get();
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
        $this->subfamilia->fill($params);
        if ($this->subfamilia->save()) {
            return response()->json([
                'message'    => 'Subfamilia creada exitosamente',
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
        $this->authorize($this);
        $this->subfamilia = $this->subfamilia->with('familia', 'margen')->find($id);
        if ($this->subfamilia) {
            return response()->json([
                'message'    => 'Subfamilia obtenida exitosamente',
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
        $this->authorize($this);
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
        $this->authorize($this);
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
