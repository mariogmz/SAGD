<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Entrada;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EntradaController extends Controller
{
    protected $entrada;

    public function __construct(Entrada $entrada)
    {
        $this->entrada = $entrada;
        // $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Entrada $entrada)
    {
        $this->authorize($this);
        return $this->entrada->with('empleado', 'estado')->get();
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
        $entradasDetalles = $request->only('entradas_detalles');
        $this->entrada->fill($params);
        if( $this->entrada->save() )
        {
            return response()->json(
                [
                    'message' => 'Entrada creada exitosamente',
                    'entrada' => $this->entrada->self()
                ],
                201,
                ['Location' => route('api.v1.entrada.show', $this->entrada->getId())]);
        } else {
            return response()->json([
                'message' => 'Entrada no creada',
                'error' => $this->entrada->errors
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
        $this->entrada = $this->entrada->find($id);
        if( $this->entrada )
        {
            return response()->json([
                'message' => 'Entrada obtenida exitosamente',
                'entrada' => $this->entrada->with('detalles.producto', 'detalles.productoMovimiento')->where('id', $id)->first()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Entrada no encontrada o no existente',
                'error' => 'No encontrada'
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
        $parameters = $request->all();
        $this->entrada = $this->entrada->find($id);
        if( empty($this->entrada) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la entrada',
                'error' => 'Entrada no encontrada'
            ], 404);
        }
        if( $this->entrada->update($parameters) )
        {
            return response()->json([
                'message' => 'Entrada se actualizo correctamente',
                'entrada' => $this->entrada->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la entrada',
                'error' => $this->entrada->errors
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
        $this->entrada = $this->entrada->find($id);
        if( empty($this->entrada) )
        {
            return response()->json([
                'message' => 'No se pudo eliminar la entrada',
                'error' => 'Entrada no encontrada'
            ], 404);
        }
        if( $this->entrada->delete() )
        {
            return response()->json([
                'message' => 'Entrada eliminada correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la entrada',
                'error' => 'El metodo de eliminar no se pudo ejecutar'
            ], 400);
        }
    }

    /**
     * Agrega un detalle a la entrada
     * @param int $id
     * @param Request
     * @return Response
     */
    public function saveDetalle($id, Request $request)
    {
        $this->authorize($this);
        $this->entrada = $this->entrada->find($id);
        if ($this->entrada) {
            $detalle = $request->all();
            if ($detalle = $this->entrada->crearDetalle($detalle)) {
                return response()->json([
                    'message' => 'Detalle agregado a Entrada exitosamente',
                    'detalle' => $detalle
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Detalle no se pudo agregar a Entrada',
                    'error' => 'Detalle no creado'
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'No se pudo encontrar la entrada',
                'error' => 'Entrada no existente'
            ], 404);
        }
    }

    /**
     * Agrega un detalle a la entrada
     * @param int $id
     * @param int $detalle_id
     * @return Response
     */
    public function unsaveDetalle($id, $detalle_id)
    {
        $this->authorize($this);
        $this->entrada = $this->entrada->find($id);
        if ($this->entrada) {
            if ($this->entrada->quitarDetalle($detalle_id)) {
                return response()->json([
                    'message' => 'Detalle removido de la Entrada exitosamente'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Detalle no se pudo remover de la Entrada',
                    'error' => 'Detalle no removido'
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'No se pudo encontrar la entrada',
                'error' => 'Entrada no existente'
            ], 404);
        }
    }

    /**
     * Carga la entrada usando sus detalles
     * @param int $id
     * @return Response
     */
    public function cargarEntrada($id)
    {
        $this->authorize($this);
        $this->entrada = $this->entrada->find($id);
        if ($this->entrada) {
            if ($this->entrada->cargar()) {
                return response()->json([
                    'message' => 'Entrada cargada exitosamente'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Entrada no pudo ser cargada',
                    'error' => 'Entrada no cargada'
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'Entrada no cargada',
                'error' => 'Entrada no se encontro o no existe'
            ], 404);
        }
    }
}
