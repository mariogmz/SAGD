<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ClienteReferencia;

class ClienteReferenciaController extends Controller
{
    protected $clienteReferencia;

    public function __construct(ClienteReferencia $clienteReferencia)
    {
        $this->clienteReferencia = $clienteReferencia;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->clienteReferencia->all();
    }

}
