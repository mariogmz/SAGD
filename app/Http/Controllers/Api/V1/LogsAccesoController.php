<?php

namespace App\Http\Controllers\Api\V1;

use App\LogAcceso;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LogsAccesoController extends Controller
{

    private $logsAcceso;

    public function __construct(LogAcceso $logsAcceso)
    {
        $this->logsAcceso = $logsAcceso;
        // $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->logsAcceso->with('empleado')->get();
    }
}
