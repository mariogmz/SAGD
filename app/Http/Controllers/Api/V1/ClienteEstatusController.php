<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ClienteEstatus;

class ClienteEstatusController extends Controller
{
    protected $clienteEstatus;

    public function __construct(ClienteEstatus $clienteEstatus)
    {
        $this->clienteEstatus= $clienteEstatus;
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
        return $this->clienteEstatus->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize($this);
        $params = $request->all();
        $this->clienteEstatus->fill($params);
        if( $this->clienteEstatus->save() )
        {
            return response()->json(
                [
                    'message' => 'Estatus creado exitosamente',
                    'clienteEstatus' => $this->clienteEstatus->self()
                ],
                201,
                ['Location' => route('api.v1.cliente-estatus.show', $this->clienteEstatus->getId())]);
        } else {
            return response()->json([
                'message' => 'Estatus no creado',
                'error' => $this->clienteEstatus->errors
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
        $this->authorize($this);
        $this->clienteEstatus= $this->clienteEstatus->find($id);
        if( $this->clienteEstatus )
        {
            return response()->json([
                'message' => 'Estatus obtenido exitosamente',
                'clienteEstatus' => $this->clienteEstatus
            ], 200);
        } else {
            return response()->json([
                'message' => 'Estatus no encontrado o no existente',
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
        $this->authorize($this);
        $parameters = $request->all();
        $this->clienteEstatus= $this->clienteEstatus->find($id);
        if( empty($this->clienteEstatus) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del Estatus',
                'error' => 'Estatus no encontrado'
            ], 404);
        }
        if( $this->clienteEstatus->update($parameters) )
        {
            return response()->json([
                'message' => 'Estatus se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del Estatus',
                'error' => $this->clienteEstatus->errors
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
        $this->clienteEstatus = $this->clienteEstatus->find($id);
        if (empty($this->clienteEstatus)) {
            return response()->json([
                'message' => 'No se pudo eliminar el estatus',
                'error'   => 'Estatus no encontrado'
            ], 404);
        } elseif ($this->clienteEstatus->delete()) {
            return response()->json([
                'message' => 'Estatus eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el estatus',
                'error'   => $this->clienteEstatus->errors
            ], 400);
        }
    }

}


