<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cliente as Cliente;

class ClienteController extends Controller
{
    protected $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->cliente->with('estatus')->get();
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
        $this->cliente->fill($params);

        $result = $this->cliente->saveWithData($params);
        if( $result )
        {
            return response()->json(
                [
                    'message' => 'Cliente creado exitosamente',
                    'cliente' => $result
                ],
                201,
                ['Location' => route('api.v1.cliente.show', $this->cliente->getId())]);
        } else {
            return response()->json([
                'message' => 'Cliente no creado',
                'error' => $this->cliente->errors
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
        $this->cliente = $this->cliente->find($id);
        if( $this->cliente )
        {
            return response()->json([
                'message' => 'Cliente obtenido exitosamente',
                'cliente' => $this->cliente
            ], 200);
        } else {
            return response()->json([
                'message' => 'Cliente no encontrado o no existente',
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
        $this->cliente = $this->cliente->find($id);
        if( empty($this->cliente) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del cliente',
                'error' => 'Cliente no encontrado'
            ], 404);
        }
        if( $this->cliente->update($parameters) )
        {
            return response()->json([
                'message' => 'Cliente se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del cliente',
                'error' => $this->cliente->errors
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->cliente = $this->cliente->find($id);
        if( empty($this->cliente) )
        {
            return response()->json([
                'message' => 'No se pudo eliminar el cliente',
                'error' => 'Cliente no encontrado'
            ], 404);
        }
        if( $this->cliente->delete() )
        {
            return response()->json([
                'message' => 'Cliente eliminado correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el cliente',
                'error' => 'El metodo de eliminar no se pudo ejecutar'
            ], 400);
        }
    }
}
