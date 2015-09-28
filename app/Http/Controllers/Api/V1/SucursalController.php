<?php

namespace App\Http\Controllers\Api\V1;

use App\Sucursal;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SucursalController extends Controller
{
    protected $sucursal;

    public function __construct(Sucursal $sucursal)
    {
        $this->sucursal = $sucursal;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sucursales = $this->sucursal->all();
        return $sucursales;
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
        $this->sucursal->fill($params);
        if( $this->sucursal->save() )
        {
            return response()->json(
                [
                    'message' => 'Sucursal creada exitosamente',
                    'sucursal' => $this->sucursal->self()
                ],
                201,
                ['Location' => route('api.v1.sucursal.show', $this->sucursal->getId())]);
        } else {
            return response()->json([
                'message' => 'Sucursal no creada',
                'error' => $this->sucursal->errors
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
        $this->sucursal = $this->sucursal->find($id);
        if( $this->sucursal )
        {
            return response()->json([
                'message' => 'Sucursal obtenida exitosamente',
                'sucursal' => $this->sucursal
            ], 200);
        } else {
            return response()->json([
                'message' => 'Sucursal no encontrada o no existente',
                'error' => 'No encontrada'
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
        $this->sucursal = $this->sucursal->find($id);
        if( empty($this->sucursal) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la Sucursal',
                'error' => 'Sucursal no encontrada'
            ], 404);
        }
        if( $this->sucursal->update($parameters) )
        {
            return response()->json([
                'message' => 'Sucursal se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la Sucursal',
                'error' => $this->sucursal->errors
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
        $this->sucursal = $this->sucursal->find($id);
        if (empty($this->sucursal)) {
            return response()->json([
                'message' => 'No se pudo eliminar la sucursal',
                'error'   => 'Sucursal no encontrada'
            ], 404);
        } elseif ($this->sucursal->delete()) {
            return response()->json([
                'message' => 'Sucursal eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la sucursal',
                'error'   => $this->sucursal->errors
            ], 400);
        }
    }
}
