<?php

namespace App\Http\Controllers\Api\V1;


use App\Cliente as Cliente;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class ClienteController extends Controller {

    protected $cliente;

    public function __construct(Cliente $cliente) {
        $this->cliente = $cliente;
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $this->authorize($this);

        return response()->json($this->cliente->with('estatus', 'user')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        $this->authorize($this);
        $params = $request->all();
        $this->cliente->fill($params);
        if ($this->cliente->guardar($params)) {
            return response()->json(
                [
                    'message' => 'Cliente creado exitosamente',
                    'cliente' => $this->cliente->self()
                ],
                201,
                ['Location' => route('api.v1.cliente.show', $this->cliente->getId())]);
        } else {
            return response()->json([
                'message' => 'Cliente no creado',
                'error'   => $this->cliente->errors
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $this->authorize($this);
        $this->cliente = $this->cliente->with('domicilios.telefonos','domicilios.codigoPostal','tabuladores.sucursal','user')->find($id);
        if (!empty($this->cliente)) {
            return response()->json([
                'message' => 'Cliente obtenido exitosamente',
                'cliente' => $this->cliente->self()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Cliente no encontrado o no existente',
                'error'   => 'No encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
        $this->authorize($this);
        $parameters = $request->all();
        $this->cliente = $this->cliente->find($id);
        if (empty($this->cliente)) {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del cliente',
                'error'   => 'Cliente no encontrado'
            ], 404);
        }
        if ($this->cliente->update($parameters)) {
            return response()->json([
                'message' => 'Cliente se actualizo correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo realizar la actualizacion del cliente',
                'error'   => $this->cliente->errors
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        $this->authorize($this);
        $this->cliente = $this->cliente->find($id);
        if (empty($this->cliente)) {
            return response()->json([
                'message' => 'No se pudo eliminar el cliente',
                'error'   => 'Cliente no encontrado'
            ], 404);
        }
        if ($this->cliente->delete()) {
            return response()->json([
                'message' => 'Cliente eliminado correctamente'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No se pudo eliminar el cliente',
                'error'   => 'El metodo de eliminar no se pudo ejecutar'
            ], 400);
        }
    }

    /**
     * Permite la búsqueda de Clientes usando 3 parámetros
     * @param Request $request
     * @return Response
     */
    public function buscar(Request $request) {
        $this->authorize($this);
        $params = $request->only('nombre', 'usuario', 'email');

        $params['nombre'] = isset($params['nombre']) ? $params['nombre'] : '*';
        $params['usuario'] = isset($params['usuario']) ? $params['usuario'] : '*';
        $params['email'] = isset($params['email']) ? $params['email'] : '*';

        if (
            $params['nombre'] === '*' &&
            $params['usuario'] === '*' &&
            $params['email'] === '*'
        ) {
            return response()->json([
                'message' => 'Debes de especificar al menos un valor de búsqueda',
                'error'   => 'Faltan parámetros de búsqueda'
            ], 400);
        }
        foreach ($params as $column => $search) {
            if ($search === '*') {
                continue;
            }
            if($column === 'email'){
                $this->cliente = $this->cliente->user();
            }
            $this->cliente = $this->cliente->where($column, 'like', "%{$search}%");
        }

        return $this->cliente->with('user')->get();
    }

    /**
     * Obtiene una lista de todos los empleados activos para los casos
     * donde se requiera enlistarlos
     */
    public function listar() {
        $this->authorize($this);
        $this->cliente = $this->cliente->whereHas('estatus', function($query) {
            $query->where('nombre','Activo');
        })->get(['id','nombre']);
        return response()->json($this->cliente, 200);
    }
}
