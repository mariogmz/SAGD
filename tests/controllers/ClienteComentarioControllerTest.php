<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\ClienteComentarioController
 */
class ClienteComentarioControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/cliente-comentario';

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->setUpMock('App\ClienteComentario');
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
        $this->mock->shouldReceive('all')->once()->andReturn('[{"id":1,"nombre":"Nuevo"}]');
        $this->app->instance('App\ClienteComentario', $this->mock);

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
        $this->app->instance('App\ClienteComentario', $this->mock);

        $this->post($this->endpoint, ['nombre' => 'Nuevo'])
            ->seeJson([
                'message' => 'Comentario creado exitosamente',
                'cliente_comentario' => 'self'
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
        $this->app->instance('App\ClienteComentario', $this->mock);

        $this->post($this->endpoint, ['nombre' => 'Nuevo'])
            ->seeJson([
                'message' => 'Comentario no creado',
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

        $this->mock->shouldReceive('find')->with(1)->andReturn(Mockery::self());
        $this->mock->shouldReceive('self')->withAnyArgs()->andReturn(['Hello']);
        $this->app->instance('App\ClienteComentario', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'cliente_comentario' => ['Hello']
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado()
    {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\ClienteComentario', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Comentario no encontrado o no existente',
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
        $parameters = ['nombre' => 'Nuevo'];

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'update' => true])->withAnyArgs();
        $this->app->instance('App\ClienteComentario', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Comentario se actualizó correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado()
    {
        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\ClienteComentario', $this->mock);

        $endpoint = $this->endpoint . '/10000';
        $parameters = ['nombre' => 'Nuevo'];

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualización del comentario',
                'error' => 'Comentario no encontrado'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_clave_repetida()
    {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['nombre' => 'Nuevo'];

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'update' => false])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\ClienteComentario', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualización del comentario',
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
        $this->app->instance('App\ClienteComentario', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Comentario eliminado correctamente'
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
        $this->app->instance('App\ClienteComentario', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el comentario',
                'error'   => 'Comentario no encontrado'
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
        $this->app->instance('App\ClienteComentario', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el comentario',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);

    }
}
