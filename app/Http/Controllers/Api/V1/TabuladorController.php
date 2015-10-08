<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tabulador;

class TabuladorController extends Controller
{
    protected $tabulador;

    public function __construct(Tabulador $tabulador)
    {
        $this->tabulador= $tabulador;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->tabulador->all();
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
        $this->tabulador->fill($params);
        if( $this->tabulador->save() )
        {
            return response()->json(
                [
                    'message' => 'Tabulador creado exitosamente',
                    'tabulador' => $this->tabulador->self()
                ],
                201,
                ['Location' => route('api.v1.tabulador.show', $this->tabulador->getId())]);
        } else {
            return response()->json([
                'message' => 'Tabulador no creado',
                'error' => $this->tabulador->errors
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
        $this->tabulador = $this->tabulador->find($id);
        if( $this->tabulador )
        {
            return response()->json([
                'message' => 'Tabulador obtenido exitosamente',
                'tabulador' => $this->tabulador
            ], 200);
        } else {
            return response()->json([
                'message' => 'Tabulador no encontrado o no existente',
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
        $this->tabulador = $this->tabulador->find($id);
        if( empty($this->tabulador) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del Tabulador',
                'error' => 'Tabulador no encontrado'
            ], 404);
        }
        if( $this->tabulador->update($parameters) )
        {
            return response()->json([
                'message' => 'Tabulador se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del Tabulador',
                'error' => $this->tabulador->errors
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
        $this->tabulador = $this->tabulador->find($id);
        if (empty($this->tabulador)) {
            return response()->json([
                'message' => 'No se pudo eliminar el Tabulador',
                'error'   => 'Tabulador no encontrado'
            ], 404);
        } elseif ($this->tabulador->delete()) {
            return response()->json([
                'message' => 'Tabulador eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el Tabulador',
                'error'   => $this->tabulador->errors
            ], 400);
        }
    }

}

