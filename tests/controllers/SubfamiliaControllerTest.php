<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\SubfamiliaController
 */
class SubfamiliaControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/subfamilia';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Subfamilia');
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
        $this->app->instance('App\Subfamilia', $this->mock);

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
        $this->app->instance('App\Subfamilia', $this->mock);

        $this->post($this->endpoint, ['clave' => 'NT', 'nombre' => 'Notebooks'])
            ->seeJson([
                'message' => 'Subfamilia creada exitosamente',
                'subfamilia'  => 'self'
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
        $this->app->instance('App\Subfamilia', $this->mock);

        $this->post($this->endpoint, ['clave' => null, 'nombre' => 'Laptops'])
            ->seeJson([
                'message' => 'Subfamilia no creada',
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
        $this->app->instance('App\Subfamilia', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'Subfamilia obtenida exitosamente',
                'subfamilia'  => 'self'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado() {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\Subfamilia', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Subfamilia no encontrada o no existente',
                'error'   => 'No encontrada'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['clave' => 'NT'];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => true
        ])->withAnyArgs();
        $this->app->instance('App\Subfamilia', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Subfamilia se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['clave' => 'NT'];

        $this->mock->shouldReceive([
            'find' => null,
        ])->withAnyArgs();
        $this->app->instance('App\Subfamilia', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la subfamilia',
                'error'   => 'Subfamilia no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_clave_repetida() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['clave' => 'NB'];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => false
        ])->withAnyArgs();
        $this->mock->errors = ['clave' => 'La clave ya existe'];
        $this->app->instance('App\Subfamilia', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la subfamilia',
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
        $this->app->instance('App\Subfamilia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Subfamilia eliminada correctamente'
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
        $this->app->instance('App\Subfamilia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la subfamilia',
                'error'   => 'Subfamilia no encontrada'
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
        $this->app->instance('App\Subfamilia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la subfamilia',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);

    }
}
