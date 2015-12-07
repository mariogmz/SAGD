<?php

namespace App\Http\Controllers\Api\V1;


use App\Ficha;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class FichaController extends Controller {

    protected $ficha;

    public function __construct(Ficha $ficha) {
        $this->ficha = $ficha;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $this->authorize($this);
        $params = $request->all();
        if (array_key_exists('calidad', $params)) {
            return response()->json($this->ficha->has('ficha')->with('caracteristicas')
                ->whereCalidad($params['calidad'])->get(), 200);
        } else {
            return response()->json($this->ficha->has('ficha')->with('caracteristicas')->get(), 200);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $this->authorize($this);
        $params = $request->all();
        $this->ficha->fill($params['ficha']);
        if ($this->ficha->save()) {
            return response()->json([
                'message'  => 'Ficha creada exitosamente',
                'ficha' => $this->ficha->self()
            ], 201,
                ['Location' => route('api.v1.ficha.show', $this->ficha->getId())]);
        } else {
            return response()->json([
                'message' => 'Ficha no creada',
                'error'   => $this->ficha->errors
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $this->authorize($this);
        $this->ficha = $this->ficha->with('caracteristicas')->find($id);
        if ($this->ficha) {
            return response()->json([
                'message' => 'Producto obtenido exitosamente',
                'ficha'   => $this->ficha->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Ficha no encontrada o no existente',
                'error'   => 'No encontrada'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->authorize($this);
        $ficha = $request->get('ficha');
        $caracteristicas = $request->get('caracteristicas');
        $this->ficha = $this->ficha->find($id);
        if (empty($this->ficha)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la ficha',
                'error'   => 'Ficha no encontrada'
            ], 404);
        } elseif ($this->ficha->update($ficha)) {
            $this->ficha->actualizarCaracteristicas($caracteristicas);

            return response()->json([
                'message' => 'Ficha se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion de la ficha',
                'error'   => $this->ficha->errors
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->authorize($this);
        $this->ficha = $this->ficha->find($id);
        if (empty($this->ficha)) {
            return response()->json([
                'message' => 'No se pudo eliminar la ficha',
                'error'   => 'Ficha no encontrada'
            ], 404);
        } elseif ($this->ficha->delete()) {
            return response()->json([
                'message' => 'Ficha eliminada correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar la ficha',
                'error'   => 'El metodo de eliminar no se pudo ejecutar'
            ], 400);
        }
    }
}
