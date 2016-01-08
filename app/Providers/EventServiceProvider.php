<?php

namespace App\Providers;


use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SucursalNueva'             => [
            'App\Listeners\CrearPreciosParaSucursalNueva',
            'App\Listeners\CrearTabuladoresParaSucursalNueva'
        ],
        'App\Events\PostEmpleadoCreado'        => [
            'App\Listeners\CrearUser',
        ],
        'App\Events\DatoContactoActualizado'   => [
            'App\Listeners\ActualizarUser',
        ],
        'App\Events\EmpleadoRolCreado'         => [
            'App\Listeners\CrearRol',
        ],
        'App\Events\CargandoSalida'            => [
            'App\Listeners\CrearProductoMovimientoDesdeSalida',
        ],
        'App\Events\CargandoEntrada'           => [
            'App\Listeners\CrearProductoMovimientoDesdeEntrada',
        ],
        'App\Events\CreandoProductoMovimiento' => [
            'App\Listeners\ActualizarExistencias',
        ],
        'App\Events\ProductoCreado'            => [
            'App\Listeners\AttachSucursales',
            'App\Listeners\InicializarExistencias',
            'App\Listeners\CrearFicha'
        ],
        'App\Events\Pretransferir'             => [
            'App\Listeners\EjecutarPretransferencia',
        ],
        'App\Events\Transferir'                => [
            'App\Listeners\EjecutarTransferencia',
        ],
        'App\Events\Cargar'                    => [
            'App\Listeners\EjecutarCarga',
        ],
        'App\Events\ClienteCreado'             => [
            'App\Listeners\CrearTabuladoresParaClienteNuevo',
            'App\Listeners\CrearDomiciliosParaClienteNuevo',
            'App\Listeners\CrearUsuarioParaClienteNuevo'
        ],
        'App\Events\ClienteActualizado'        => [
            'App\Listeners\CrearUsuarioParaClienteActualizado'
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events) {
        parent::boot($events);

        //
    }
}
