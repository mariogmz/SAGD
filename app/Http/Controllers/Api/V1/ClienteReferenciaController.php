<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ClienteReferencia;

class ClienteReferenciaController extends Controller
{
    protected $clienteReferencia;

    public function __construct(ClienteReferencia $clienteReferencia)
    {
        $this->clienteReferencia = $clienteReferencia;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->clienteReferencia->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $this->clienteReferencia->fill($params);
        if( $this->clienteReferencia->save() )
        {
            return response()->json(
                [
                    'message' => 'Referencia creada exitosamente',
                    'clienteReferencia' => $this->clienteReferencia->self()
                ],
                201,
                ['Location' => route('api.v1.cliente-referencia.show', $this->clienteReferencia->getId())]);
        } else {
            return response()->json([
                'message' => 'Referencia no creada',
                'error' => $this->clienteReferencia->errors
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $this->clienteReferencia = $this->clienteReferencia->find($id);
        if( $this->clienteReferencia )
        {
            return response()->json([
                'message' => 'Referencia obtenida exitosamente',
                'clienteReferencia' => $this->clienteReferencia
            ], 200);
        } else {
            return response()->json([
                'message' => 'Referencia no encontrada o no existente',
                'error' => 'No encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $parameters = $request->all();
        $this->clienteReferencia = $this->clienteReferencia->find($id);
        if( empty($this->clienteReferencia) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la Referencia',
                'error' => 'Referencia no encontrada'
            ], 404);
        }
        if( $this->clienteReferencia->update($parameters) )
        {
            return response()->json([
                'message' => 'Referencia se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la Referencia',
                'error' => $this->clienteReferencia->errors
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
        $this->clienteReferencia = $this->clienteReferencia->find($id);
        if (empty($this->clienteReferencia)) {
            return response()->json([
                'message' => 'No se pudo eliminar la referencia',
                'error'   => 'Referencia no encontrada'
            ], 404);
        } elseif ($this->clienteReferencia->delete()) {
            return response()->json([
                'message' => 'Referencia eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la referencia',
                'error'   => $this->clienteReferencia->errors
            ], 400);
        }
    }

}

