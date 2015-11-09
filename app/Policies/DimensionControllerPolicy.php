<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\DimensionController;

class DimensionControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Dimensions
     *
     * @param  User  $user
     * @param  DimensionController $controller
     * @return bool
     */
    public function index(User $user, DimensionController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar un Dimension
     *
     * @param  User  $user
     * @param  DimensionController $controller
     * @return bool
     */
    public function store(User $user, DimensionController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'store')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un Dimension
     *
     * @param  User  $user
     * @param  DimensionController $controller
     * @return bool
     */
    public function show(User $user, DimensionController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'show')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede actualizar un Dimension
     *
     * @param  User  $user
     * @param  DimensionController $controller
     * @return bool
     */
    public function update(User $user, DimensionController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'update')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Dimension
     *
     * @param  User  $user
     * @param  DimensionController $controller
     * @return bool
     */
    public function destroy(User $user, DimensionController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'destroy')->first();
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
