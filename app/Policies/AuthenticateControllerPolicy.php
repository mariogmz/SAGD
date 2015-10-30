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
        return true;
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
        return true;
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
        return true;
    }
}
