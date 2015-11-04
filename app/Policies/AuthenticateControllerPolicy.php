<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\AuthenticateController;

class AuthenticateControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Authenticates
     *
     * @param  User  $user
     * @param  AuthenticateController $controller
     * @return bool
     */
    public function authenticate(User $user, AuthenticateController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'authenticate')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar un Authenticate
     *
     * @param  User  $user
     * @param  AuthenticateController $controller
     * @return bool
     */
    public function getAuthenticatedEmpleado(User $user, AuthenticateController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'getAuthenticatedEmpleado')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un Authenticate
     *
     * @param  User  $user
     * @param  AuthenticateController $controller
     * @return bool
     */
    public function logout(User $user, AuthenticateController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'logout')->first();
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
