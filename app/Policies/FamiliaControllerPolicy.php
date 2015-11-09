<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\FamiliaController;

class FamiliaControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Familias
     *
     * @param  User  $user
     * @param  FamiliaController $controller
     * @return bool
     */
    public function index(User $user, FamiliaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar un Familia
     *
     * @param  User  $user
     * @param  FamiliaController $controller
     * @return bool
     */
    public function store(User $user, FamiliaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'store')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un Familia
     *
     * @param  User  $user
     * @param  FamiliaController $controller
     * @return bool
     */
    public function show(User $user, FamiliaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'show')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede actualizar un Familia
     *
     * @param  User  $user
     * @param  FamiliaController $controller
     * @return bool
     */
    public function update(User $user, FamiliaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'update')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Familia
     *
     * @param  User  $user
     * @param  FamiliaController $controller
     * @return bool
     */
    public function destroy(User $user, FamiliaController $controller)
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
