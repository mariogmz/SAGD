<?php

namespace App\Http\Controllers\Api\V1;

use App\Telefono;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TelefonoController extends Controller
{

    protected $telefono;

    public function __construct(Telefono $telefono)
    {
        $this->telefono = $telefono;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize($this);
        return $this->telefono->with('domicilio.codigoPostal')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize($this);
        $params = $request->all();
        $this->telefono->fill($params);
        if ($this->telefono->save()) {
            return response()->json([
                'message' => 'Teléfono agregado exitosamente',
                'telefono' => $this->telefono->self()
            ], 201, [
                'Location' => route('api.v1.telefono.show', $this->telefono->getId())
            ]);
        } else {
            return response()->json([
                'message' => 'Teléfono no creado',
                'error' => $this->telefono->errors
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
        $this->authorize($this);
        $this->telefono = $this->telefono->with('domicilio.codigoPostal')->find($id);
        if ($this->telefono)
        {
            return response()->json([
                'message' => 'Teléfono obtenido exitosamente',
                'telefono' => $this->telefono->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Teléfono no encontrado o no existente',
                'error' => 'No encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize($this);
        $params = $request->all();
        $this->telefono = $this->telefono->find($id);
        if( empty($this->telefono) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del telefono',
                'error' => 'Teléfono no encontrado'
            ], 404);
        } elseif ($this->telefono->update($params)) {
            return response()->json([
                'message' => 'Teléfono se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del telefono',
                'error' => $this->telefono->errors
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
        $this->authorize($this);
        $this->telefono = $this->telefono->find($id);
        if( empty($this->telefono) )
        {
            return response()->json([
                'message' => 'No se pudo eliminar el telefono',
                'error' => 'Teléfono no encontrado'
            ], 404);
        } elseif ($this->telefono->delete()) {
            return response()->json([
                'message' => 'Teléfono eliminado correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el telefono',
                'error' => $this->telefono->errors
            ], 400);
        }
    }
}
