<?php

namespace App\Policies;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Http\Controllers\Api\V1\AuthenticateController'        => 'App\Policies\AuthenticateControllerPolicy',
        'App\Http\Controllers\Api\V1\ClienteController'             => 'App\Policies\ClienteControllerPolicy',
        'App\Http\Controllers\Api\V1\ClienteEstatusController'      => 'App\Policies\ClienteEstatusControllerPolicy',
        'App\Http\Controllers\Api\V1\ClienteReferenciaController'   => 'App\Policies\ClienteReferenciaControllerPolicy',
        'App\Http\Controllers\Api\V1\CodigoPostalController'        => 'App\Policies\CodigoPostalControllerPolicy',
        'App\Http\Controllers\Api\V1\DimensionController'           => 'App\Policies\DimensionControllerPolicy',
        'App\Http\Controllers\Api\V1\DomicilioController'           => 'App\Policies\DomicilioControllerPolicy',
        'App\Http\Controllers\Api\V1\EntradaController'             => 'App\Policies\EntradaControllerPolicy',
        'App\Http\Controllers\Api\V1\EmpleadoController'            => 'App\Policies\EmpleadoControllerPolicy',
        'App\Http\Controllers\Api\V1\FamiliaController'             => 'App\Policies\FamiliaControllerPolicy',
        'App\Http\Controllers\Api\V1\LogsAccesoEmpleadoController'  => 'App\Policies\LogsAccesoEmpleadoControllerPolicy',
        'App\Http\Controllers\Api\V1\MarcaController'               => 'App\Policies\MarcaControllerPolicy',
        'App\Http\Controllers\Api\V1\MargenController'              => 'App\Policies\MargenControllerPolicy',
        'App\Http\Controllers\Api\V1\PasswordController'            => 'App\Policies\PasswordControllerPolicy',
        'App\Http\Controllers\Api\V1\PermisoController'             => 'App\Policies\PermisoControllerPolicy',
        'App\Http\Controllers\Api\V1\PrecioController'              => 'App\Policies\PrecioControllerPolicy',
        'App\Http\Controllers\Api\V1\ProductoController'            => 'App\Policies\ProductoControllerPolicy',
        'App\Http\Controllers\Api\V1\ProductoSucursalController'    => 'App\Policies\ProductoSucursalControllerPolicy',
        'App\Http\Controllers\Api\V1\ProveedorController'           => 'App\Policies\ProveedorControllerPolicy',
        'App\Http\Controllers\Api\V1\RolController'                 => 'App\Policies\RolControllerPolicy',
        'App\Http\Controllers\Api\V1\SalidaController'              => 'App\Policies\SalidaControllerPolicy',
        'App\Http\Controllers\Api\V1\SubfamiliaController'          => 'App\Policies\SubfamiliaControllerPolicy',
        'App\Http\Controllers\Api\V1\SucursalController'            => 'App\Policies\SucursalControllerPolicy',
        'App\Http\Controllers\Api\V1\TelefonoController'            => 'App\Policies\TelefonoControllerPolicy',
        'App\Http\Controllers\Api\V1\TipoGarantiaController'        => 'App\Policies\TipoGarantiaControllerPolicy',
        'App\Http\Controllers\Api\V1\UnidadController'              => 'App\Policies\UnidadControllerPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
