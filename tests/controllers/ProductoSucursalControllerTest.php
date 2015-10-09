<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\ProductoSucursalController
 */
class ProductoSucursalControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/producto-sucursal';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\ProductoSucursal');
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
        $this->app->instance('App\ProductoSucursal', $this->mock);

        $this->get($this->endpoint)
            ->assertResponseStatus(200);
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
        $this->app->instance('App\ProductoSucursal', $this->mock);

        $this->post($this->endpoint, ['upc' => 123456])
            ->seeJson([
                'message' => 'Producto asociado a sucursal exitosamente',
                'producto'  => 'self'
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
        $this->app->instance('App\ProductoSucursal', $this->mock);

        $this->post($this->endpoint, ['upc' => 123456])
            ->seeJson([
                'message' => 'Producto no asociado a sucursal',
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
        $this->app->instance('App\ProductoSucursal', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'Asociación producto-sucursal obtenida exitosamente',
                'producto'  => 'self'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado() {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\ProductoSucursal', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Asociación producto-sucursal no encontrada',
                'error'   => 'No encontrada'
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
        $this->app->instance('App\ProductoSucursal', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Asociación de producto-sucursal actualizada correctamente'
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
        $this->app->instance('App\ProductoSucursal', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo actualizar la relación producto-sucursal',
                'error'   => 'ProductoSucursal no encontrado'
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
        $this->app->instance('App\ProductoSucursal', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo actualizar la relación producto-sucursal',
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
        $this->app->instance('App\ProductoSucursal', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Relación producto-sucursal eliminada correctamente'
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
        $this->app->instance('App\ProductoSucursal', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la relación producto-sucursal',
                'error'   => 'ProductoSucursal no encontrado'
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
        $this->app->instance('App\ProductoSucursal', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la relación producto-sucursal',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);

    }
}
