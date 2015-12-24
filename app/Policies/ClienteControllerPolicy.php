<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\ClienteController;

class ClienteControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Clientes
     *
     * @param  User  $user
     * @param  ClienteController $controller
     * @return bool
     */
    public function index(User $user, ClienteController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar un Cliente
     *
     * @param  User  $user
     * @param  ClienteController $controller
     * @return bool
     */
    public function store(User $user, ClienteController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'store')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un Cliente
     *
     * @param  User  $user
     * @param  ClienteController $controller
     * @return bool
     */
    public function show(User $user, ClienteController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'show')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede actualizar un Cliente
     *
     * @param  User  $user
     * @param  ClienteController $controller
     * @return bool
     */
    public function update(User $user, ClienteController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'update')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Cliente
     *
     * @param  User  $user
     * @param  ClienteController $controller
     * @return bool
     */
    public function destroy(User $user, ClienteController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'destroy')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede buscar un Cliente
     *
     * @param  User  $user
     * @param  ClienteController $controller
     * @return bool
     */
    public function buscar(User $user, ClienteController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'buscar')->first();
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
