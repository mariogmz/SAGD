<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\ClienteController
 */
class ClienteReferenciaControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/cliente-referencia';

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->setUpMock('App\ClienteReferencia');
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
     */
    public function test_GET_index()
    {
        $this->mock->shouldReceive('all')->once()->andReturn('[{"id":1,"nombre":"Por medio de Google"}]');
        $this->app->instance('App\ClienteReferencia', $this->mock);

        $this->get($this->endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::store
     */
    public function test_POST_store()
    {
        $this->mock
            ->shouldReceive([
                'fill' => Mockery::self(),
                'save' => true,
                'self' => 'self',
                'getId' => 1
            ])
            ->withAnyArgs();
        $this->app->instance('App\ClienteReferencia', $this->mock);

        $this->post($this->endpoint, ['nombre' => 'Por medio de google'])
            ->seeJson([
                'message' => 'Referencia creada exitosamente',
                'clienteReferencia' => 'self'
            ])
            ->assertResponseStatus(201);
    }

    /**
     * @covers ::store
     */
    public function test_POST_store_bad_data()
    {
        $this->mock
            ->shouldReceive(['fill' => Mockery::self(), 'save' => false])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\ClienteReferencia', $this->mock);

        $this->post($this->endpoint, ['nombre' => 'Por medio de Google'])
            ->seeJson([
                'message' => 'Referencia no creada',
                'error' => 'Errors'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_ok()
    {
        $endpoint = $this->endpoint . '/1';

        $this->mock->shouldReceive('find')->with(1)->andReturn(true);
        $this->app->instance('App\ClienteReferencia', $this->mock);


        $this->get($endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado()
    {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\ClienteReferencia', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Referencia no encontrada o no existente',
                'error' => 'No encontrado'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok()
    {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['nombre' => 'Por medio de Google'];

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'update' => true])->withAnyArgs();
        $this->app->instance('App\ClienteReferencia', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Referencia se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado()
    {
        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\ClienteReferencia', $this->mock);

        $endpoint = $this->endpoint . '/10000';
        $parameters = ['nombre' => 'Por medio de Google'];

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la Referencia',
                'error' => 'Referencia no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_clave_repetida()
    {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['nombre' => 'Z'];

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'update' => false])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\ClienteReferencia', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la Referencia',
                'error' => 'Errors'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::destroy
     */
    public function test_DELETE_destroy_ok()
    {
        $endpoint = $this->endpoint . '/1';

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'delete' => true])->withAnyArgs();
        $this->app->instance('App\ClienteReferencia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Referencia eliminada correctamente'
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
        $this->app->instance('App\ClienteReferencia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la referencia',
                'error'   => 'Referencia no encontrada'
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
        $this->app->instance('App\ClienteReferencia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la referencia',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);

    }
}
