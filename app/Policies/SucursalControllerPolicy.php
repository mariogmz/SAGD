<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\SucursalController;

class SucursalControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Sucursals
     *
     * @param  User  $user
     * @param  SucursalController $controller
     * @return bool
     */
    public function index(User $user, SucursalController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar un Sucursal
     *
     * @param  User  $user
     * @param  SucursalController $controller
     * @return bool
     */
    public function store(User $user, SucursalController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'store')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un Sucursal
     *
     * @param  User  $user
     * @param  SucursalController $controller
     * @return bool
     */
    public function show(User $user, SucursalController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'show')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede actualizar un Sucursal
     *
     * @param  User  $user
     * @param  SucursalController $controller
     * @return bool
     */
    public function update(User $user, SucursalController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'update')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Sucursal
     *
     * @param  User  $user
     * @param  SucursalController $controller
     * @return bool
     */
    public function destroy(User $user, SucursalController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'destroy')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede listar las Sucursales con cierto Proveedor
     *
     * @param  User  $user
     * @param  SucursalController $controller
     * @return bool
     */
    public function conProveedor(User $user, SucursalController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'conProveedor')->first();
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
