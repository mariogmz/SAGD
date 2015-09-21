<?php

namespace App\Http\Controllers\Api\V1;

use App\Margen;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MargenController extends Controller
{
    protected $margen;

    public function __construct(Margen $margen)
    {
        $this->margen = $margen;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $margenes = $this->margen->paginate(15);
        return $margenes;
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
        $this->margen->fill($params);
        if( $this->margen->save() )
        {
            return response()->json(
                [
                    'message' => 'Margen creado exitosamente',
                    'margen' => $this->margen->self()
                ],
                201,
                ['Location' => route('api.v1.margen.show', $this->margen->getId())]);
        } else {
            return response()->json([
                'message' => 'Margen no creado',
                'error' => $this->margen->errors
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
        $this->margen = $this->margen->find($id);
        if( $this->margen )
        {
            return response()->json([
                'message' => 'Margen obtenido exitosamente',
                'margen' => $this->margen
            ], 200);
        } else {
            return response()->json([
                'message' => 'Margen no encontrado o no existente',
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
        $this->margen = $this->margen->find($id);
        if( empty($this->margen) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del margen',
                'error' => 'Margen no encontrado'
            ], 404);
        }
        if( $this->margen->update($parameters) )
        {
            return response()->json([
                'message' => 'Margen se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del margen',
                'error' => $this->margen->errors
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *a
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->margen = $this->margen->find($id);
        if( empty($this->margen) )
        {
            return response()->json([
                'message' => 'No se pudo eliminar el margen',
                'error' => 'Margen no encontrado'
            ], 404);
        }
        if( $this->margen->delete() )
        {
            return response()->json([
                'message' => 'Margen eliminado correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el margen',
                'error' => 'El metodo de eliminar no se pudo ejecutar'
            ], 400);
        }
    }
}
