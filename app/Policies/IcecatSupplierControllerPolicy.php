<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\IcecatSupplierController;

class IcecatSupplierControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los IcecatSuppliers
     *
     * @param  User  $user
     * @param  IcecatSupplierController $controller
     * @return bool
     */
    public function index(User $user, IcecatSupplierController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede actualizar un IcecatSupplier
     *
     * @param User $user
     * @param IcecatSupplierController $controller
     * @return bool
     */
    public function update(User $user, IcecatSupplierController $controller){
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'update')->first();
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
