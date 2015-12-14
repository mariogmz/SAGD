<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\IcecatFeature;

class IcecatFeatureController extends Controller {

    protected $icecat_feature;

    public function __construct(IcecatFeature $icecat_feature) {
        $this->icecat_feature = $icecat_feature;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $campo
     * @param mixed $valor
     * @return \Illuminate\Http\Response
     */
    public function index($campo = null, $valor = null) {
        $this->authorize($this);
        if (isset($campo) && isset($valor)) {
            $valor = str_replace(' ', '%', $valor);
            return response()->json($this->icecat_feature->where($campo, 'LIKE', "%{$valor}%")->get(), 200);
        } else {
            return response()->json($this->icecat_feature->all(), 200);
        }
    }
}
