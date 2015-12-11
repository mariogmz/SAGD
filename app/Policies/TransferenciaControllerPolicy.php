<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\TransferenciaController;

class TransferenciaControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Transferencias de Salida
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function indexSalidas(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'indexSalidas')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede listar los Transferencias de Entrada
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function indexEntradas(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'indexEntradas')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar un Transferencia
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function create(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'create')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un Transferencia
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function show(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'show')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede actualizar un Transferencia
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function update(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'update')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Transferencia
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function destroy(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'destroy')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar detalles de una transferencia
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function saveDetalle(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'saveDetalle')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede quitar detalles de una transferencia
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function unsaveDetalle(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'unsaveDetalle')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede transferir un Transferencia
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function transferir(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'transferir')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede cargar un Transferencia
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function cargar(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'cargar')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede escanear productos para la carga
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function escanear(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'escanear')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede cambiar el estatus a cargando destino
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function cargandoDestino(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'cargandoDestino')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede resetear la cantidad escaneada de un detalle
     *
     * @param  User  $user
     * @param  TransferenciaController $controller
     * @return bool
     */
    public function reset(User $user, TransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'reset')->first();
        return !empty($permiso);
    }

    /**
     * Normaliza el nombre del controlador a su nombre de clase unicamente
     * @param $controller
     * @return string
     */
    private function normalizeControllerName($controller)
    {
        $className = get_class($controller);
        $controllerName = [];
        preg_match('/(\w+)$/', $className, $controllerName);
        return $controllerName[0];
    }
}
