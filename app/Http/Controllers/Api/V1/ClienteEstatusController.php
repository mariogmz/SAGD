<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ClienteEstatus;

class ClienteEstatusController extends Controller
{
    protected $clienteEstatus;

    public function __construct(ClienteReferencia $clienteReferencia)
    {
        $this->clienteEstatus= $clienteEstatus;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->clienteEstatus->all();
    }

}
