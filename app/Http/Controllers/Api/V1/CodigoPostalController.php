<?php

namespace App\Http\Controllers\Api\V1;

use App\CodigoPostal;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CodigoPostalController extends Controller
{

    protected $codigoPostal;

    public function __construct(CodigoPostal $codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->codigoPostal->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $this->codigoPostal->fill($params);
        if ($this->codigoPostal->save())
        {
            return response()->json([
                'message' => 'Codigo Postal agregado exitosamente',
                'codigo_postal' => $this->codigoPostal->self()
            ], 201, [
                'Location' => route('api.v1.codigo-postal.show', $this->codigoPostal->getId())
            ]);
        } else {
            return response()->json([
                'message' => 'Codigo Postal no creado',
                'error' => $this->codigoPostal->errors
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
        $this->codigoPostal = $this->codigoPostal->find($id);
        if ($this->codigoPostal)
        {
            return response()->json([
                'message' => 'Codigo Postal obtenido exitosamente',
                'codigo_postal' => $this->codigoPostal->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Codigo Postal no encontrado o no existente',
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
        $params = $request->all();
        $this->codigoPostal = $this->codigoPostal->find($id);
        if( empty($this->codigoPostal) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del codigo postal',
                'error' => 'Codigo Postal no encontrado'
            ], 404);
        } elseif ($this->codigoPostal->update($params)) {
            return response()->json([
                'message' => 'Codigo Postal se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del codigo postal',
                'error' => $this->codigoPostal->errors
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
        $this->codigoPostal = $this->codigoPostal->find($id);
        if( empty($this->codigoPostal) )
        {
            return response()->json([
                'message' => 'No se pudo eliminar el codigo postal',
                'error' => 'Codigo Postal no encontrado'
            ], 404);
        } elseif ($this->codigoPostal->delete()) {
            return response()->json([
                'message' => 'Codigo Postal eliminado correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el codigo postal',
                'error' => $this->codigoPostal->errors
            ], 400);
        }
    }
}
