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
            ->with('origen','destino')
            ->selectRaw('sum(cantidad) as cantidad, sucursal_origen_id, sucursal_destino_id')
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
        return response()->json([], 200);
    }
}
