<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Rol;

class RolController extends Controller
{
    protected $rol;

    public function __construct(Rol $rol)
    {
        $this->rol = $rol;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->rol->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $params = $request->all();
        $this->rol->fill($params);
        if ($this->rol->save()) {
            return response()->json([
                'message' => 'Rol creado exitosamente',
                'rol' => $this->rol->self()
            ], 201,
                ['Location' => route('api.v1.rol.show', $this->rol->getId())]);
        } else {
            return response()->json([
                'message' => 'Rol no creado',
                'error'   => $this->rol->errors
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
        $this->rol = $this->rol->find($id);
        if ($this->rol) {
            return response()->json([
                'message' => 'Rol obtenido exitosamente',
                'rol' => $this->rol->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Rol no encontrado o no existente',
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
        $this->rol = $this->rol->find($id);
        if (empty($this->rol)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del rol',
                'error'   => 'Rol no encontrado'
            ], 404);
        } elseif ($this->rol->update($params)) {
            return response()->json([
                'message' => 'Rol se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del rol',
                'error'   => $this->rol->errors
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
        $this->rol = $this->rol->find($id);
        if (empty($this->rol)) {
            return response()->json([
                'message' => 'No se pudo eliminar el rol',
                'error'   => 'Rol no encontrado'
            ], 404);
        } elseif ($this->rol->delete()) {
            return response()->json([
                'message' => 'Rol eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el rol',
                'error'   => $this->rol->errors
            ], 400);
        }
    }
}

