<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\PretransferenciaController;

class PretransferenciaControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Pretransferencias
     *
     * @param  User  $user
     * @param  PretransferenciaController $controller
     * @return bool
     */
    public function index(User $user, PretransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede imprimir la lista de pretransferencia
     *
     * @param  User  $user
     * @param  PretransferenciaController $controller
     * @return bool
     */
    public function imprimir(User $user, PretransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'imprimir')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede marcas las pretransferencias como transferidas
     *
     * @param  User  $user
     * @param  PretransferenciaController $controller
     * @return bool
     */
    public function transferir(User $user, PretransferenciaController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'transferir')->first();
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
