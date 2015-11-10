<?php

namespace App\Http\Controllers\Api\V1;

use App\Salida;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class SalidaController extends Controller
{
    protected $salida;

    public function __construct(Salida $salida)
    {
        $this->salida = $salida;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Salida $salida)
    {
        $this->authorize($this);
        return $this->salida->all();
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
        $this->salida->fill($params);
        if( $this->salida->save() )
        {
            return response()->json(
                [
                    'message' => 'Salida creada exitosamente',
                    'salida' => $this->salida->self()
                ],
                201,
                ['Location' => route('api.v1.salida.show', $this->salida->getId())]);
        } else {
            return response()->json([
                'message' => 'Salida no creada',
                'error' => $this->salida->errors
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
        $this->salida = $this->salida->find($id);
        if( $this->salida )
        {
            return response()->json([
                'message' => 'Salida obtenida exitosamente',
                'salida' => $this->salida
            ], 200);
        } else {
            return response()->json([
                'message' => 'Salida no encontrada o no existente',
                'error' => 'No encontrada'
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
        $parameters = $request->all();
        $this->salida = $this->salida->find($id);
        if( empty($this->salida) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la salida',
                'error' => 'Salida no encontrada'
            ], 404);
        }
        if( $this->salida->update($parameters) )
        {
            return response()->json([
                'message' => 'Salida se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la salida',
                'error' => $this->salida->errors
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
        $this->salida = $this->salida->find($id);
        if( empty($this->salida) )
        {
            return response()->json([
                'message' => 'No se pudo eliminar la salida',
                'error' => 'Salida no encontrada'
            ], 404);
        }
        if( $this->salida->delete() )
        {
            return response()->json([
                'message' => 'Salida eliminada correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la salida',
                'error' => 'El metodo de eliminar no se pudo ejecutar'
            ], 400);
        }
    }
}
