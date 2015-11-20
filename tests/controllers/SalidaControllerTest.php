<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Carbon\Carbon;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\SalidaController
 */
class SalidaControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/salida';

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Salida');
    }

    public function setUpMock($class)
    {
        $mock = Mockery::mock($class);
        return $mock;
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @covers ::index
     * @group feature-salidas
     */
    public function test_GET_index() {
        $this->mock->shouldReceive([
            'with->get' => []
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->get($this->endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::store
     * @group feature-salidas
     */
    public function test_POST_store()
    {
        $this->mock
            ->shouldReceive([
                'fill' => Mockery::self(),
                'save' => Mockery::self(),
                'self' => 'self',
                'getId' => 1
            ])
            ->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->post($this->endpoint, ['fecha_salida' => Carbon::now(),
            'motivo' => 'algo', 'empleado_id' => 1, 'sucursal_id' => 1,
            'estado_salida_id' => 1])
            ->seeJson([
                'message' => 'Salida creada exitosamente',
                'salida' => 'self'
            ])
            ->assertResponseStatus(201);
    }

    /**
     * @covers ::store
     * @group feature-salidas
     */
    public function test_POST_store_bad_data()
    {
        $this->mock
            ->shouldReceive(['fill' => Mockery::self(), 'save' => false])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\Salida', $this->mock);

        $this->post($this->endpoint, ['clave' => 'Z', 'nombre' => 'Zegucom'])
            ->seeJson([
                'message' => 'Salida no creada',
                'error' => 'Errors'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::show
     * @group feature-salidas
     */
    public function test_GET_show_ok()
    {
        $endpoint = $this->endpoint . '/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'with' => Mockery::self(),
            'where' => Mockery::self(),
            'first' => []
            ])
            ->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'Salida obtenida exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     * @group feature-salidas
     */
    public function test_GET_show_no_encontrado()
    {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\Salida', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Salida no encontrada o no existente',
                'error' => 'No encontrada'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     * @group feature-salidas
     */
    public function test_PUT_update_ok()
    {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['motivo' => 'Useless'];

        $this->mock
            ->shouldReceive([
                'find' => Mockery::self(),
                'update' => Mockery::self(),
                'self' => []
            ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Salida se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     * @group feature-salidas
     */
    public function test_PUT_update_no_encontrado()
    {
        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\Salida', $this->mock);

        $endpoint = $this->endpoint . '/10000';
        $parameters = ['nombre' => 'PUT'];

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la salida',
                'error' => 'Salida no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     * @group feature-salidas
     */
    public function test_PUT_update_clave_repetida()
    {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['clave' => 'Z'];

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'update' => false])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\Salida', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la salida',
                'error' => 'Errors'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::destroy
     * @group feature-salidas
     */
    public function test_DELETE_destroy_ok()
    {
        $endpoint = $this->endpoint . '/10';

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'delete' => true])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Salida eliminada correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::destroy
     * @group feature-salidas
     */
    public function test_DELETE_destroy_not_found()
    {
        $endpoint = $this->endpoint . '/123456';

        $this->mock
            ->shouldReceive('find')->with(123456)->andReturn(null);
        $this->app->instance('App\Salida', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la salida',
                'error' => 'Salida no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::destroy
     * @group feature-salidas
     */
    public function test_DELETE_destroy_bad()
    {
        $endpoint = $this->endpoint . '/10';

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'delete' => false])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la salida',
                'error' => 'El metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::saveDetalle
     * @group feature-salidas
     */
    public function test_POST_saveDetalle()
    {
        $endpoint = $this->endpoint . '/1/detalles';
        $detalles = [
            'cantidad' => 5,
            'upc' => 'xyz',
            'producto_id' => 1
        ];

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'getAttribute' => Mockery::self(),
            'last' => [],
            'crearDetalle' => true
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->post($endpoint, $detalles)
            ->seeJson([
                'message' => 'Detalle agregado a Salida exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::saveDetalle
     * @group feature-salidas
     */
    public function test_POST_saveDetalle_salida_no_encontrada()
    {
        $endpoint = $this->endpoint . '/1/detalles';
        $detalles = [
            'cantidad' => 5,
            'upc' => 'xyz',
            'producto_id' => 1
        ];

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->post($endpoint, $detalles)
            ->seeJson([
                'message' => 'No se pudo encontrar la salida',
                'error' => 'Salida no existente'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::saveDetalle
     * @group feature-salidas
     */
    public function test_POST_saveDetalle_detalle_no_creado()
    {
        $endpoint = $this->endpoint . '/1/detalles';
        $detalles = [
            'cantidad' => 5,
            'upc' => 'xyz',
            'producto_id' => 1
        ];

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'crearDetalle' => false
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->post($endpoint, $detalles)
            ->seeJson([
                'message' => 'Detalle no se pudo agregar a Salida',
                'error' => 'Detalle no creado'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::unsaveDetalle
     * @group feature-salidas
     */
    public function test_DELETE_unsaveDetalle()
    {
        $endpoint = $this->endpoint . '/1/detalles/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'quitarDetalle' => true
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Detalle removido de la Salida exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::unsaveDetalle
     * @group feature-salidas
     */
    public function test_DELETE_unsaveDetalle_salida_invalida()
    {
        $endpoint = $this->endpoint . '/1/detalles/1';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo encontrar la salida',
                'error' => 'Salida no existente'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::unsaveDetalle
     * @group feature-salidas
     */
    public function test_DELETE_unsaveDetalle_quitarDetalle_invalido()
    {
        $endpoint = $this->endpoint . '/1/detalles/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'quitarDetalle' => false
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Detalle no se pudo remover de la Salida',
                'error' => 'Detalle no removido'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::cargarSalida
     * @group feature-salidas
     */
    public function test_GET_cargarSalida_exitosa()
    {
        $endpoint = $this->endpoint . '/1/cargar';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'cargar' => true
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Salida cargada exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::cargarSalida
     * @group feature-salidas
     */
    public function test_GET_cargarSalida_salida_invalida()
    {
        $endpoint = $this->endpoint . '/1/cargar';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Salida no cargada',
                'error' => 'Salida no se encontro o no existe'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::cargarSalida
     * @group feature-salidas
     */
    public function test_GET_cargarSalida_cargar_invalido()
    {
        $endpoint = $this->endpoint . '/1/cargar';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'cargar' => false,
            'sobrepasaExistencias' => false
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Salida no pudo ser cargada',
                'error' => 'Salida no cargada'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::cargarSalida
     * @group feature-salidas
     */
    public function test_GET_cargarSalida_cargar_invalido_con_existencia_invalida()
    {
        $endpoint = $this->endpoint . '/1/cargar';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'cargar' => false,
            'sobrepasaExistencias' => true
        ])->withAnyArgs();
        $this->app->instance('App\Salida', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Algunas partidas de la salida tienen cantidad superior a las existencias del producto',
                'error' => 'Cantidad es invalida en algunas partidas'
            ])
            ->assertResponseStatus(400);
    }
}
