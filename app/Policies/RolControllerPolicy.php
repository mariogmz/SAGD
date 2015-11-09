<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\RolController;

class RolControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Rols
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function index(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function store(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'store')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function show(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'show')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede actualizar un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function update(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'update')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function destroy(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'destroy')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function generales(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'generales')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function individuales(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'individuales')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function attach(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'attach')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function detach(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'detach')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function attachEmpleado(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'attachEmpleado')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function detachEmpleado(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'detachEmpleado')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Rol
     *
     * @param  User  $user
     * @param  RolController $controller
     * @return bool
     */
    public function empleados(User $user, RolController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'empleados')->first();
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
