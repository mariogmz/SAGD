<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\IcecatController;

class IcecatControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Icecats
     *
     * @param  User  $user
     * @param  IcecatController $controller
     * @return bool
     */
    public function obtenerFicha(User $user, IcecatController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'obtenerFicha')->first();
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
