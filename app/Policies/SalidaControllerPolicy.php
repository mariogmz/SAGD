<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\SalidaController;

class SalidaControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Salidas
     *
     * @param  User  $user
     * @param  SalidaController $controller
     * @return bool
     */
    public function index(User $user, SalidaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar un Salida
     *
     * @param  User  $user
     * @param  SalidaController $controller
     * @return bool
     */
    public function store(User $user, SalidaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'store')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un Salida
     *
     * @param  User  $user
     * @param  SalidaController $controller
     * @return bool
     */
    public function show(User $user, SalidaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'show')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede actualizar un Salida
     *
     * @param  User  $user
     * @param  SalidaController $controller
     * @return bool
     */
    public function update(User $user, SalidaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'update')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Salida
     *
     * @param  User  $user
     * @param  SalidaController $controller
     * @return bool
     */
    public function destroy(User $user, SalidaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'destroy')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Salida
     *
     * @param  User  $user
     * @param  SalidaController $controller
     * @return bool
     */
    public function saveDetalle(User $user, SalidaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'saveDetalle')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Salida
     *
     * @param  User  $user
     * @param  SalidaController $controller
     * @return bool
     */
    public function unsaveDetalle(User $user, SalidaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'unsaveDetalle')->first();
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
