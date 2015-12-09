<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\IcecatSupplier;

class IcecatSupplierController extends Controller {

    protected $icecat_supplier;

    public function __construct(IcecatSupplier $icecat_supplier) {
        $this->icecat_supplier = $icecat_supplier;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function index($name = null) {
        $this->authorize($this);
        if (empty($name)) {
            return response()->json($this->icecat_supplier->all(), 200);
        } else {
            return response()->json($this->icecat_supplier->whereName($name)->all(), 200);
        }
    }
}
