<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Marca as Marca;

class MarcaController extends Controller
{
    protected $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     * @param string $campo
     * @param mixed $valor
     * @return Response
     */
    public function index($campo = null, $valor = null)
    {
        $this->authorize($this);
        if(isset($campo) && isset($valor)){
            $valor = str_replace(' ', '%', $valor);
            return $this->marca->where($campo, 'LIKE', "%{$valor}%")->get();
        } else {
            return $this->marca->all();
        }
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
        $this->marca->fill($params);
        if( $this->marca->save() )
        {
            return response()->json(
                [
                    'message' => 'Marca creada exitosamente',
                    'marca' => $this->marca->self()
                ],
                201,
                ['Location' => route('api.v1.marca.show', $this->marca->getId())]);
        } else {
            return response()->json([
                'message' => 'Marca no creada',
                'error' => $this->marca->errors
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
        $this->marca = $this->marca->find($id);
        if( $this->marca )
        {
            return response()->json([
                'message' => 'Marca obtenida exitosamente',
                'marca' => $this->marca
            ], 200);
        } else {
            return response()->json([
                'message' => 'Marca no encontrada o no existente',
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
        $this->authorize($this);
        $parameters = $request->all();
        $this->marca = $this->marca->find($id);
        if( empty($this->marca) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la marca',
                'error' => 'Marca no encontrada'
            ], 404);
        }
        if( $this->marca->update($parameters) )
        {
            return response()->json([
                'message' => 'Marca se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la marca',
                'error' => $this->marca->errors
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
        $this->authorize($this);
        $this->marca = $this->marca->find($id);
        if( empty($this->marca) )
        {
            return response()->json([
                'message' => 'No se pudo eliminar la marca',
                'error' => 'Marca no encontrada'
            ], 404);
        }
        if( $this->marca->delete() )
        {
            return response()->json([
                'message' => 'Marca eliminada correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la marca',
                'error' => 'El metodo de eliminar no se pudo ejecutar'
            ], 400);
        }
    }
}
