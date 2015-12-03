<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Sucursal;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PretransferenciaController extends Controller
{
    protected $sucursal;

    public function __construct(Sucursal $sucursal)
    {
        $this->sucursal = $sucursal;
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
        return $this->sucursal
            ->selectRaw('sucursales.nombre, SUM(existencias.cantidad_pretransferencia_destino) as cantidad_pretransferencia_destino')
            ->join('productos_sucursales', 'productos_sucursales.sucursal_id', '=', 'sucursales.id')
            ->join('existencias', 'existencias.productos_sucursales_id', '=', 'productos_sucursales.id')
            ->where('existencias.cantidad_pretransferencia_destino', '>', 0)
            ->where('sucursales.id', '<>', $id)
            ->groupBy('sucursales.id')
            ->get();
    }
}
