<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\TipoGarantiaController
 */
class TipoGarantiaControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/tipo-garantia';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\TipoGarantia');
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
        $this->app->instance('App\TipoGarantia', $this->mock);

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
        $this->app->instance('App\TipoGarantia', $this->mock);

        $this->post($this->endpoint, ['seriado' => 1, 'descripcion' => '30 dias en tienda', 'dias' => 30])
            ->seeJson([
                'message' => 'TipoGarantia creado exitosamente',
                'tipoGarantia'  => 'self'
            ])
            ->assertResponseStatus(201);
    }

    /**
     * @covers ::store
     */
    public function test_POST_store_bad_data() {
        $this->mock
            ->shouldReceive(['fill' => Mockery::self(), 'save' => false])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\TipoGarantia', $this->mock);

        $this->post($this->endpoint,  ['seriado' => 1, 'descripcion' => '30 dias en tienda', 'dias' => 30])
            ->seeJson([
                'message' => 'TipoGarantia no creado',
                'error'   => 'Errors'
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
        $this->app->instance('App\TipoGarantia', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'TipoGarantia obtenido exitosamente',
                'tipoGarantia'  => 'self'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado() {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\TipoGarantia', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'TipoGarantia no encontrado o no existente',
                'error'   => 'No encontrado'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['seriado' => false];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => true
        ])->withAnyArgs();
        $this->app->instance('App\TipoGarantia', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'TipoGarantia se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['seriado' => false];

        $this->mock->shouldReceive([
            'find' => null,
        ])->withAnyArgs();
        $this->app->instance('App\TipoGarantia', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del tipo de garantia',
                'error'   => 'TipoGarantia no encontrado'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_seriado_no_valido() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['seriado' => 'hello'];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => false
        ])->withAnyArgs();
        $this->mock->errors = ['seriado' => 'Seriado debe ser booleano'];
        $this->app->instance('App\TipoGarantia', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del tipo de garantia',
                'error'   => ['seriado' => 'Seriado debe ser booleano']
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
        $this->app->instance('App\TipoGarantia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'TipoGarantia eliminado exitosamente',
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
        $this->app->instance('App\TipoGarantia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el tipo de garantia',
                'error'   => 'TipoGarantia no encontrado o no existente'
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
        $this->app->instance('App\TipoGarantia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el tipo de garantia',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);

    }
}
