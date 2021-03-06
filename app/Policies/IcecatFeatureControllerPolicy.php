<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\IcecatFeatureController;

class IcecatFeatureControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los IcecatFeatures
     *
     * @param  User  $user
     * @param  IcecatFeatureController $controller
     * @return bool
     */
    public function index(User $user, IcecatFeatureController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un IcecatFeature
     *
     * @param  User  $user
     * @param  IcecatFeatureController $controller
     * @return bool
     */
    public function show(User $user, IcecatFeatureController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'show')->first();
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
