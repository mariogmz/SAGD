<?php

namespace App\Http\Controllers\Api\V1;

use App\Salida;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class SalidaController extends Controller
{
    protected $salida;

    public function __construct(Salida $salida)
    {
        $this->salida = $salida;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Salida $salida)
    {
        $this->authorize($this);
        return $this->salida->with('empleado', 'estado')->get();
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
        $salidasDetalles = $request->only('salidas_detalles');
        $this->salida->fill($params);
        if( $this->salida->save() )
        {
            return response()->json(
                [
                    'message' => 'Salida creada exitosamente',
                    'salida' => $this->salida->self()
                ],
                201,
                ['Location' => route('api.v1.salida.show', $this->salida->getId())]);
        } else {
            return response()->json([
                'message' => 'Salida no creada',
                'error' => $this->salida->errors
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
        $this->salida = $this->salida->find($id);
        if( $this->salida )
        {
            return response()->json([
                'message' => 'Salida obtenida exitosamente',
                'salida' => $this->salida->with('detalles.producto', 'detalles.productoMovimiento')->where('id', $id)->first()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Salida no encontrada o no existente',
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
        $this->salida = $this->salida->find($id);
        if( empty($this->salida) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la salida',
                'error' => 'Salida no encontrada'
            ], 404);
        }
        if( $this->salida->update($parameters) )
        {
            return response()->json([
                'message' => 'Salida se actualizo correctamente',
                'salida' => $this->salida->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la salida',
                'error' => $this->salida->errors
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
        $this->salida = $this->salida->find($id);
        if( empty($this->salida) )
        {
            return response()->json([
                'message' => 'No se pudo eliminar la salida',
                'error' => 'Salida no encontrada'
            ], 404);
        }
        if( $this->salida->delete() )
        {
            return response()->json([
                'message' => 'Salida eliminada correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la salida',
                'error' => 'El metodo de eliminar no se pudo ejecutar'
            ], 400);
        }
    }

    /**
     * Agrega un detalle a la salida
     * @param int $id
     * @param Request
     * @return Response
     */
    public function saveDetalle($id, Request $request)
    {
        $this->authorize($this);
        $this->salida = $this->salida->find($id);
        if ($this->salida) {
            $detalle = $request->all();
            if ($detalle = $this->salida->crearDetalle($detalle)) {
                return response()->json([
                    'message' => 'Detalle agregado a Salida exitosamente',
                    'detalle' => $detalle
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Detalle no se pudo agregar a Salida',
                    'error' => 'Detalle no creado'
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'No se pudo encontrar la salida',
                'error' => 'Salida no existente'
            ], 404);
        }
    }

    /**
     * Agrega un detalle a la salida
     * @param int $id
     * @param int $detalle_id
     * @return Response
     */
    public function unsaveDetalle($id, $detalle_id)
    {
        $this->authorize($this);
        $this->salida = $this->salida->find($id);
        if ($this->salida) {
            if ($this->salida->quitarDetalle($detalle_id)) {
                return response()->json([
                    'message' => 'Detalle removido de la Salida exitosamente'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Detalle no se pudo remover de la Salida',
                    'error' => 'Detalle no removido'
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'No se pudo encontrar la salida',
                'error' => 'Salida no existente'
            ], 404);
        }
    }

    /**
     * Carga la salida usando sus detalles
     * @param int $id
     * @return Response
     */
    public function cargarSalida($id)
    {
        $this->authorize($this);
        $this->salida = $this->salida->find($id);
        if ($this->salida) {
            if ($this->salida->cargar()) {
                return response()->json([
                    'message' => 'Salida cargada exitosamente'
                ], 200);
            } else {
                if ($this->salida->sobrepasaExistencias()) {
                    return response()->json([
                        'message' => 'Algunas partidas de la salida tienen cantidad superior a las existencias del producto',
                        'error' => 'Cantidad es invalida en algunas partidas'
                    ], 400);
                } else {
                    return response()->json([
                        'message' => 'Salida no pudo ser cargada',
                        'error' => 'Salida no cargada'
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'message' => 'Salida no cargada',
                'error' => 'Salida no se encontro o no existe'
            ], 404);
        }
    }
}
