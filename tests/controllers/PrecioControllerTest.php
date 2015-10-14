<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\PrecioController
 */
class PrecioControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/precio';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Precio');
    }

    public function setUpMock($class) {
        $mock = Mockery::mock($class);

        return $mock;
    }

    public function tearDown() {
        Mockery::close();
    }

    /**
     * @covers ::index
     */
    public function test_GET_index() {
        $this->mock->shouldReceive('all')->once()->andReturn('success');
        $this->app->instance('App\Precio', $this->mock);

        $this->get($this->endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::calcular
     */
    public function test_GET_calcular_success() {
        $precio = 5940.00;
        $costo = 5444.03;
        $margen_id = 14;
        $endpoint = "/v1/calcular-precio/?precio={$precio}&costo={$costo}&margen_id={$margen_id}";

        $this->mock->shouldReceive([
            'calcularPrecios' => ['Exito']
        ])->withAnyArgs();

        $this->app->instance('App\Precio', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message'   => 'Precios calculados correctamente.',
                'resultado' => ['Exito']
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::calcular
     */
    public function test_GET_calcular_failure() {
        $precio = 5940.00;
        $costo = 5444.03;
        $endpoint = "/v1/calcular-precio/?precio={$precio}&costo={$costo}";

        $this->mock->shouldReceive([
            'calcularPrecios' => null
        ])->withAnyArgs();

        $this->app->instance('App\Precio', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'No se pudo realizar el cálculo de precios y utilidades.',
                'error'   => [
                    'Calculo' => 'Ocurrió un error al momento de realizar los cálculos.'
                ]
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::store
     */
    public function test_POST_store() {
        $this->mock
            ->shouldReceive([
                'fill'  => Mockery::self(),
                'save'  => true,
                'self'  => 'self',
                'getId' => 1
            ])
            ->withAnyArgs();
        $this->app->instance('App\Precio', $this->mock);

        $this->post($this->endpoint, ['upc' => 123456])
            ->seeJson([
                'message' => 'Precio creado exitosamente',
                'precio'  => 'self'
            ])
            ->assertResponseStatus(201);
    }

    /**
     * @covers ::store
     */
    public function test_POST_store_bad_data() {
        $this->mock
            ->shouldReceive(['fill' => Mockery::self(), 'save' => false])->withAnyArgs();
        $this->mock->errors = ['clave' => 'Clave es requerido'];
        $this->app->instance('App\Precio', $this->mock);

        $this->post($this->endpoint, ['upc' => 123456])
            ->seeJson([
                'message' => 'Precio no creado',
                'error'   => ['clave' => 'Clave es requerido']
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_ok() {
        $endpoint = $this->endpoint . '/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'self' => 'self'
        ])->withAnyArgs();
        $this->app->instance('App\Precio', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'Precio obtenido exitosamente',
                'precio'  => 'self'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado() {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\Precio', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Precio no encontrado o no existente',
                'error'   => 'No encontrado'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['upc' => 123456];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => true
        ])->withAnyArgs();
        $this->app->instance('App\Precio', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Precio se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['upc' => 123456];

        $this->mock->shouldReceive([
            'find' => null,
        ])->withAnyArgs();
        $this->app->instance('App\Precio', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del precio',
                'error'   => 'Precio no encontrado'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_clave_repetida() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['upc' => 14569];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => false
        ])->withAnyArgs();
        $this->mock->errors = ['clave' => 'La clave ya existe'];
        $this->app->instance('App\Precio', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del precio',
                'error'   => ['clave' => 'La clave ya existe']
            ])->assertResponseStatus(400);
    }

    /**
     * @covers ::destroy
     */
    public function test_DELETE_destroy_ok() {
        $endpoint = $this->endpoint . '/10';

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'delete' => true
        ])->withAnyArgs();
        $this->app->instance('App\Precio', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Precio eliminado correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::destroy
     */
    public function test_DELETE_destroy_not_found() {
        $endpoint = $this->endpoint . '/1';

        $this->mock->shouldReceive([
            'find' => null,
        ])->withAnyArgs();
        $this->app->instance('App\Precio', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el precio',
                'error'   => 'Precio no encontrado'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::destroy
     */
    public function test_DELETE_destroy_bad() {
        $endpoint = $this->endpoint . '/1';

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'delete' => false,
        ])->withAnyArgs();
        $this->mock->errors = 'Metodo de eliminar no se pudo ejecutar';
        $this->app->instance('App\Precio', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el precio',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);

    }
}
