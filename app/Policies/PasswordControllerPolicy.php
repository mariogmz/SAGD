<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\PasswordController;

class PasswordControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Passwords
     *
     * @param  User  $user
     * @param  PasswordController $controller
     * @return bool
     */
    public function postEmail(User $user, PasswordController $controller)
    {
        return true;
    }

    /**
     * Determinar si el usuario puede guardar un Password
     *
     * @param  User  $user
     * @param  PasswordController $controller
     * @return bool
     */
    public function postReset(User $user, PasswordController $controller)
    {
        return true;
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
