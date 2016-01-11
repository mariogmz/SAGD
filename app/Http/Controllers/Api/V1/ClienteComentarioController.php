<?php

namespace App\Http\Controllers\Api\V1;


use App\ClienteComentario;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class ClienteComentarioController extends Controller {

    protected $cliente_comentario;

    /**
     * ClienteComentarioController constructor.
     * @param $cliente_comentario
     */
    public function __construct(ClienteComentario $cliente_comentario) {
        $this->cliente_comentario = $cliente_comentario;
        $this->middleware('jwt.auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize($this);

        return response()->json($this->cliente_comentario->all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->authorize($this);
        $params = $request->all();
        $this->cliente_comentario->fill($params);
        if ($this->cliente_comentario->save()) {
            return response()->json([
                'message'           => 'Comentario creado exitosamente',
                'cliente_comentario' => $this->cliente_comentario->self()
            ], 201,
                ['Location' => route('api.v1.cliente-comentario.show', $this->cliente_comentario->getId())]);
        } else {
            return response()->json([
                'message' => 'Comentario no creado',
                'error'   => $this->cliente_comentario->errors
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
        $this->cliente_comentario = $this->cliente_comentario->find($id);
        if (!empty($this->cliente_comentario)) {
            return response()->json([
                'message'            => 'Comentario obtenido correctamente.',
                'cliente_comentario' => $this->cliente_comentario->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Comentario no encontrado o no existente',
                'error'   => 'No encontrado'
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
        $parameters = $request->all();
        $this->cliente_comentario = $this->cliente_comentario->find($id);
        if (empty($this->cliente_comentario)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualización del comentario',
                'error'   => 'Comentario no encontrado'
            ], 404);
        }
        if ($this->cliente_comentario->update($parameters)) {
            return response()->json([
                'message' => 'Comentario se actualizó correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualización del comentario',
                'error'   => $this->cliente_comentario->errors
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
        $this->cliente_comentario = $this->cliente_comentario->find($id);
        if (empty($this->cliente_comentario)) {
            return response()->json([
                'message' => 'No se pudo eliminar el comentario',
                'error'   => 'Comentario no encontrado'
            ], 404);
        } else if ($this->cliente_comentario->delete()) {
            return response()->json([
                'message' => 'Comentario eliminado correctamente',
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el comentario',
                'error'   => $this->cliente_comentario->errors
            ], 400);
        }
    }
}
