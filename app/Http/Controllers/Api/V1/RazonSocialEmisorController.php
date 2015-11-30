<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\RazonSocialEmisor;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RazonSocialEmisorController extends Controller
{
    protected $razonSocialEmisor;

    public function __construct(RazonSocialEmisor $razonSocialEmisor)
    {
        $this->razonSocialEmisor = $razonSocialEmisor;
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
        return $this->razonSocialEmisor->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize($this);
        $params = $request->all();
        $this->razonSocialEmisor->fill($params);
        if ($this->razonSocialEmisor->save()) {
            return response()->json([
                'message' => 'Razon Social Emisor creada exitosamente',
                'razonSocialEmisor' => $this->razonSocialEmisor->self()
            ], 201,
                ['Location' => route('api.v1.razon-social-emisor.show', $this->razonSocialEmisor->getId())]);
        } else {
            return response()->json([
                'message' => 'Razon Social Emisor no creada',
                'error'   => $this->razonSocialEmisor->errors
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $this->authorize($this);
        $this->razonSocialEmisor = $this->razonSocialEmisor->find($id);
        if ($this->razonSocialEmisor) {
            return response()->json([
                'message' => 'Razon Social Emisor obtenida exitosamente',
                'razonSocialEmisor' => $this->razonSocialEmisor->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Razon Social Emisor no encontrada o no existente',
                'error'   => 'No encontrada'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize($this);
        $params = $request->all();
        $this->razonSocialEmisor = $this->razonSocialEmisor->find($id);
        if (empty($this->razonSocialEmisor)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la razon social',
                'error'   => 'Razon Social Emisor no encontrado'
            ], 404);
        } elseif ($this->razonSocialEmisor->update($params)) {
            return response()->json([
                'message' => 'Razon Social Emisor se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la razon social',
                'error'   => $this->razonSocialEmisor->errors
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
        $this->razonSocialEmisor = $this->razonSocialEmisor->find($id);
        if (empty($this->razonSocialEmisor)) {
            return response()->json([
                'message' => 'No se pudo eliminar la razonSocialEmisor',
                'error'   => 'Razon Social Emisor no encontrada'
            ], 404);
        } elseif ($this->razonSocialEmisor->delete()) {
            return response()->json([
                'message' => 'Razon Social Emisor eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la razonSocialEmisor',
                'error'   => $this->razonSocialEmisor->errors
            ], 400);
        }
    }

    public function emisorEntrada()
    {
        $this->authorize($this);
        // TODO: Obtener solo los de Dicotech y Jorge
        $this->razonSocialEmisor = $this->razonSocialEmisor->all();
        return $this->razonSocialEmisor;
    }
}
