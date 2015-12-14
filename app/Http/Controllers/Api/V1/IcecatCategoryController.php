<?php

namespace App\Http\Controllers\Api\V1;

use App\IcecatCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IcecatCategoryController extends Controller
{
    protected $icecat_category;

    public function __construct(IcecatCategory $icecat_category) {
        $this->icecat_category = $icecat_category;
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

            return response()->json($this->icecat_category->where($campo, 'LIKE', $valor)->get(), 200);
        } else {
            return response()->json($this->icecat_category->all(), 200);

        }
    }

    /**
     * Updates the subfamilia_id from IcecatCategory
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->authorize($this);
        $subfamilia_id = $request->get('subfamilia_id');
        $this->icecat_category = $this->icecat_category->find($id);

        if ($this->icecat_category) {
            if ($this->icecat_category->update(['subfamilia_id' => $subfamilia_id])) {
                return response()->json([
                    'message'  => 'Relación actualizada correctamente',
                    'category' => $this->icecat_category->self()
                ], 200);
            } else {
                return response()->json([
                    'message' => 'No se pudo actualizar la categoría',
                    'error'   => $this->icecat_category->errors
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'No se pudo actualizar la categoría',
                'error'   => 'La categoría no fué encontrada'
            ], 404);
        }
    }
}
