<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\IcecatSupplier;
use Illuminate\Http\Request;

class IcecatSupplierController extends Controller {

    protected $icecat_supplier;

    public function __construct(IcecatSupplier $icecat_supplier) {
        $this->icecat_supplier = $icecat_supplier;
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
            $valor = '%' . str_replace(' ', '%', $valor) . '%';

            return response()->json($this->icecat_supplier->where($campo, 'LIKE', $valor)->get(), 200);
        } else {
            return response()->json($this->icecat_supplier->all(), 200);

        }
    }

    /**
     * Updates the marca_id from IcecatSupplier
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->authorize($this);
        $marca_id = $request->get('marca_id');
        $this->icecat_supplier = $this->icecat_supplier->find($id);

        if ($this->icecat_supplier) {
            if ($this->icecat_supplier->update(['marca_id' => $marca_id])) {
                return response()->json([
                    'message'  => 'Relación actualizada correctamente',
                    'supplier' => $this->icecat_supplier->self()
                ], 200);
            } else {
                return response()->json([
                    'message' => 'No se pudo actualizar el Fabricante',
                    'error'   => $this->icecat_supplier->errors
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'No se pudo actualizar el Fabricante',
                'error'   => 'El Fabricante no fué encontrado'
            ], 404);
        }
    }
}
