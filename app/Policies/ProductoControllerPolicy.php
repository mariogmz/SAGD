<?php

namespace App\Policies;

use App\User;
use App\Empleado;
use App\Cliente;
use App\Http\Controllers\Api\V1\ProductoController;

class ProductoControllerPolicy
{
    /**
     * Determinar si el usuario puede listar los Productos
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function index(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'index')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede guardar un Producto
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function store(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'store')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede ver un Producto
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function show(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'show')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede actualizar un Producto
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function update(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'update')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede eliminar un Producto
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function destroy(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'destroy')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede buscar un Producto
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function buscarUpc(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'buscarUpc')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede listar existencias de un Producto
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function indexExistencias(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'indexExistencias')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede pretransferir existencias de un Producto
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function pretransferir(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'pretransferir')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede listar movimientos de un Producto
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function indexMovimientos(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'indexMovimientos')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede realizar una búsqueda de un Producto
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function buscar(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'buscar')->first();
        return !empty($permiso);
    }

    /**
     * Determinar si el usuario puede listar entradas de un Producto
     *
     * @param  User  $user
     * @param  ProductoController $controller
     * @return bool
     */
    public function entradas(User $user, ProductoController $controller)
    {
        $controller = $this->normalizeControllerName($controller);
        $permisos = $user->morphable->permisos();
        $permiso = $permisos->where('controlador', $controller)->where('accion', 'entradas')->first();
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
