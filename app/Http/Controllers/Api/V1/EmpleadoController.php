<?php

namespace App\Http\Controllers\Api\V1;

use App\Empleado;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Rol;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    protected $empleado;
    protected $rol;

    public function __construct(Empleado $empleado, Rol $rol)
    {
        $this->empleado = $empleado;
        $this->rol = $rol;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $this->authorize($this);
        if ($request->has('sucursal')) {
            $sucursal = $request->only('sucursal');
            return $this->empleado->where('sucursal_id', $sucursal)->get();
        }
        return $this->empleado->with('sucursal')->get();
    }

    /**
     * Store a newly created resource in storage.
     * El parametro de datos_contacto es obligatorio para crear un Empleado por medio de la API.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->authorize($this);
        $params = $request->all();
        $datosContacto = $request->has('datos_contacto') ? $params['datos_contacto'] : null;
        $this->empleado->fill($params);
        if (!empty($datosContacto) && $this->empleado->guardar($datosContacto)) {
            return response()->json([
                'message' => 'Empleado creado exitosamente',
                'empleado' => $this->empleado->self()
            ], 201, [
                'Location' => route('api.v1.empleado.show', $this->empleado->getId())
            ]);
        } else {
            return response()->json([
                'message' => 'Empleado no creado',
                'error' => $this->empleado->errors
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $this->authorize($this);
        $this->empleado = $this->empleado->with('datoContacto', 'sucursal')->find($id);
        if ($this->empleado) {
            return response()->json([
                'message' => 'Empleado obtenido exitosamente',
                'empleado' => $this->empleado->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Empleado no encontrado o no existente',
                'error' => 'No encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        $this->empleado = $this->empleado->find($id);
        if (empty($this->empleado)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del empleado',
                'error' => 'Empleado no encontrado'
            ], 404);
        } elseif ( $this->empleado->actualizar($params) || $this->empleado->update($params) ) {
            return response()->json([
                'message' => 'Empleado se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del empleado',
                'error' => $this->empleado->errors
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $this->authorize($this);
        $this->empleado = $this->empleado->find($id);
        if (empty($this->empleado)) {
            return response()->json([
                'message' => 'No se pudo eliminar el empleado',
                'error' => 'Empleado no encontrado'
            ], 404);
        } elseif ($this->empleado->delete()) {
            return response()->json([
                'message' => 'Empleado eliminado correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el empleado',
                'error' => $this->empleado->errors
            ], 400);
        }
    }

    /**
     * Agrega un Rol a un Empleado
     * @param Request $request
     * @param int $empleado
     * @param int $rol
     * @return Response
     */
    public function attach(Request $request, $empleado, $rol) {
        $this->empleado = $this->empleado->find($empleado);
        $this->rol = $this->rol->find($rol);
        if ($this->empleado && $this->rol) {
            $this->empleado->roles()->attach($this->rol->id);
            return response()->json([
                'message' => 'Rol asignado a empleado exitosamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Rol o Empleado no encontrado, intente nuevamente',
                'error' => 'No se asigno rol a empleado'
            ], 400);
        }
    }

    /**
     * Remueve un Rol de un Empleado
     * @param Request $request
     * @param int $empleado
     * @param int $rol
     * @return Response
     */
    public function detach(Request $request, $empleado, $rol) {
        $this->empleado = $this->empleado->find($empleado);
        $this->rol = $this->rol->find($rol);
        if ($this->empleado && $this->rol) {
            $this->empleado->roles()->detach($this->rol->id);
            return response()->json([
                'message' => 'Rol removido del empleado exitosamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Rol o Empleado no encontrado, intente nuevamente',
                'error' => 'No se removio el rol del empleado'
            ], 400);
        }
    }
}
