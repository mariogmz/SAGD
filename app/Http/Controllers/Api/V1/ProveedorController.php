<?php

namespace App\Http\Controllers\Api\V1;

use App\Proveedor;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProveedorController extends Controller
{
    protected $proveedor;

    public function __construct(Proveedor $proveedor)
    {
        $this->proveedor = $proveedor;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$proveedores = $this->proveedor->all();
        //return $proveedores;

        $proveedores = Proveedor::paginate(15);
        return $proveedores->toJson();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $this->proveedor->fill($params);
        if( $this->proveedor->save() )
        {
            return response()->json(
                [
                    'message' => 'Proveedor creado exitosamente',
                    'proveedor' => $this->proveedor->self()
                ],
                201,
                ['Location' => route('api.v1.proveedor.show', $this->proveedor->getId())]);
        } else {
            return response()->json([
                'message' => 'Proveedor no creado',
                'error' => $this->proveedor->errors
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $this->proveedor = $this->proveedor->find($id);
        if( $this->proveedor )
        {
            return response()->json([
                'message' => 'Proveedor obtenido exitosamente',
                'proveedor' => $this->proveedor
            ], 200);
        } else {
            return response()->json([
                'message' => 'Proveedor no encontrado o no existente',
                'error' => 'No encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $parameters = $request->all();
        $this->proveedor = $this->proveedor->find($id);
        if( empty($this->proveedor) )
        {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del proveedor',
                'error' => 'Proveedor no encontrado'
            ], 404);
        }
        if( $this->proveedor->update($parameters) )
        {
            return response()->json([
                'message' => 'Proveedor se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del Proveedor',
                'error' => $this->proveedor->errors
            ], 400);
        }
    }
}
