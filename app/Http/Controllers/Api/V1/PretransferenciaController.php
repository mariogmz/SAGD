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
            ->with('origen', 'destino', 'empleado')
            ->selectRaw('sum(cantidad) as cantidad, sucursal_origen_id, sucursal_destino_id, GROUP_CONCAT(DISTINCT empleados.nombre SEPARATOR", ") as empleados')
            ->join('empleados', 'pretransferencias.empleado_id', '=', 'empleados.id')
            ->where('sucursal_origen_id', $id)
            ->groupBy('sucursal_destino_id')
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
}
