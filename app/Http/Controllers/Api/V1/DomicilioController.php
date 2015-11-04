<?php

namespace App\Http\Controllers\Api\V1;

use App\Domicilio;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DomicilioController extends Controller
{

    protected $domicilio;

    public function __construct(Domicilio $domicilio)
    {
        $this->domicilio = $domicilio;
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
        return $this->domicilio->with('codigoPostal', 'telefonos')->get();
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
        $this->domicilio->fill($params);
        if ($this->domicilio->save()) {
            return response()->json([
                'message' => 'Domicilio agregado exitosamente',
                'domicilio' => $this->domicilio->self()
            ], 201, [
                'Location' => route('api.v1.domicilio.show', $this->domicilio->getId())
            ]);
        } else {
            return response()->json([
                'message' => 'Domicilio no creado',
                'error' => $this->domicilio->errors
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
        $this->domicilio = $this->domicilio->with('codigoPostal', 'telefonos')->find($id);
        if ($this->domicilio)
        {
            return response()->json([
                'message' => 'Domicilio obtenido exitosamente',
                'domicilio' => $this->domicilio->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Domicilio no encontrado o no existente',
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
        $this->domicilio = $this->domicilio->find($id);
        if( empty($this->domicilio) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del domicilio',
                'error' => 'Domicilio no encontrado'
            ], 404);
        } elseif ($this->domicilio->update($params)) {
            return response()->json([
                'message' => 'Domicilio se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del domicilio',
                'error' => $this->domicilio->errors
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
        $this->domicilio = $this->domicilio->find($id);
        if( empty($this->domicilio) )
        {
            return response()->json([
                'message' => 'No se pudo eliminar el domicilio',
                'error' => 'Domicilio no encontrado'
            ], 404);
        } elseif ($this->domicilio->delete()) {
            return response()->json([
                'message' => 'Domicilio eliminado correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el domicilio',
                'error' => $this->domicilio->errors
            ], 400);
        }
    }
}
