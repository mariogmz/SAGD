<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Pretransferencia;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PretransferenciaController extends Controller
{
    protected $pretransferencia;

    public function __construct(Pretransferencia $pretransferencia)
    {
        $this->pretransferencia = $pretransferencia;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $this->authorize($this);
        return $this->pretransferencia
            ->with('origen', 'destino', 'empleado', 'estado')
            ->selectRaw('sum(cantidad) as cantidad, sucursal_origen_id, sucursal_destino_id, estado_pretransferencia_id, GROUP_CONCAT(DISTINCT empleados.nombre SEPARATOR", ") as empleados, GROUP_CONCAT(DISTINCT pretransferencias.id SEPARATOR"|") as ids')
            ->join('empleados', 'pretransferencias.empleado_id', '=', 'empleados.id')
            ->where('sucursal_origen_id', $id)
            ->groupBy(['sucursal_destino_id', 'estado_pretransferencia_id'])
            ->get();
    }

    /**
     * Compila un PDF y lo regresa
     *
     * @param int $origen
     * @param int $destino
     * @return PDF
     */
    public function imprimir($origen, $destino)
    {
        $this->authorize($this);
        return $this->pretransferencia->pdf($origen, $destino);
    }

    public function transferir($origen, $destino)
    {
        $this->authorize($this);
        if ($this->pretransferencia->transferir($origen, $destino)) {
            return response()->json([
                'message' => 'Pretransferencias marcadas como transferidas'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Pretranferencias no marcadas como transferidas'
            ], 400);
        }
    }

    /**
     * Borra una pretransferencia
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
        $this->authorize($this);
        $this->pretransferencia = $this->pretransferencia->find($id);
        if ($this->pretransferencia) {
            if ($this->pretransferencia->delete()) {
                return response()->json([
                    'message' => 'Pretransferencia eliminada exitosamente',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Pretransferencia no eliminada',
                    'error' => 'Pretransferencia no eliminada',
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'No se elimino la pretransferencia',
                'error' => 'Pretransferencia no encontrada'
            ], 404);
        }
    }
}
