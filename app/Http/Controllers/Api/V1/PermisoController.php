<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller {

    protected $permiso;

    public function __construct(Permiso $permiso) {
        $this->permiso = $permiso;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return $this->permiso->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $params = $request->all();
        $this->permiso->fill($params);
        if ($this->permiso->save()) {
            return response()->json([
                'message' => 'Permiso creado exitosamente',
                'permiso'  => $this->permiso->self()
            ], 201,
                ['Location' => route('api.v1.permiso.show', $this->permiso->getId())]);
        } else {
            return response()->json([
                'message' => 'Permiso no creado',
                'error'   => $this->permiso->errors
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
        $this->permiso = $this->permiso->find($id);
        if ($this->permiso) {
            return response()->json([
                'message' => 'Permiso obtenido exitosamente',
                'permiso'  => $this->permiso->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Permiso no encontrado o no existente',
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
        $this->permiso = $this->permiso->find($id);
        if (empty($this->permiso)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del permiso',
                'error'   => 'Permiso no encontrado'
            ], 404);
        } elseif ($this->permiso->update($params)) {
            return response()->json([
                'message' => 'Permiso se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del permiso',
                'error'   => $this->permiso->errors
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
        $this->permiso = $this->permiso->find($id);
        if (empty($this->permiso)) {
            return response()->json([
                'message' => 'No se pudo eliminar el permiso',
                'error'   => 'Permiso no encontrado'
            ], 404);
        } elseif ($this->permiso->delete()) {
            return response()->json([
                'message' => 'Permiso eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el permiso',
                'error'   => $this->permiso->errors
            ], 400);
        }
    }

    /**
     * Regresa todos los Permisos que tienen los Roles por default
     *
     * @return Response
     */
    public function roles() {
        return $this->permiso->permisosRoles();
    }

    /**
     * Regresa todos los Permisos de todos los Empleados
     *
     * @return Response
     */
    public function individuales() {
        return $this->permiso->permisosIndividuales();
    }
}
