<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class EntradaControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determinar si el usuario puede listar los Entradas
     *
     * @param  User  $user
     * @param  EntradaController $controller
     * @return bool
     */
    public function index(User $user, EntradaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar un Entrada
     *
     * @param  User  $user
     * @param  EntradaController $controller
     * @return bool
     */
    public function store(User $user, EntradaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'store')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un Entrada
     *
     * @param  User  $user
     * @param  EntradaController $controller
     * @return bool
     */
    public function show(User $user, EntradaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'show')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede actualizar un Entrada
     *
     * @param  User  $user
     * @param  EntradaController $controller
     * @return bool
     */
    public function update(User $user, EntradaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'update')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Entrada
     *
     * @param  User  $user
     * @param  EntradaController $controller
     * @return bool
     */
    public function destroy(User $user, EntradaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'destroy')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede crear un detalle de una Entrada
     *
     * @param  User  $user
     * @param  EntradaController $controller
     * @return bool
     */
    public function saveDetalle(User $user, EntradaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'saveDetalle')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un detalle de una Entrada
     *
     * @param  User  $user
     * @param  EntradaController $controller
     * @return bool
     */
    public function unsaveDetalle(User $user, EntradaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'unsaveDetalle')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede cargar un Entrada
     *
     * @param  User  $user
     * @param  EntradaController $controller
     * @return bool
     */
    public function cargarEntrada(User $user, EntradaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'cargarEntrada')->first();
        return !empty($permiso);
    }
}
