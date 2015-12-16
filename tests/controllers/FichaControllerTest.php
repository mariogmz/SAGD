<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\FichaController
 */
class FichaControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/ficha';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Ficha');
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
        $this->mock->shouldReceive([
            'with' => Mockery::self(),
            'has'  => Mockery::self(),
            'get'  => 'success'
        ])->once()->withAnyArgs();
        $this->app->instance('App\Ficha', $this->mock);
        $this->get($this->endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::index
     */
    public function test_GET_index_with_params() {
        $this->mock->shouldReceive([
            'with'         => Mockery::self(),
            'has'          => Mockery::self(),
            'whereCalidad' => Mockery::self(),
            'get'          => 'success'
        ])->once()->withAnyArgs();
        $this->app->instance('App\Ficha', $this->mock);
        $this->get($this->endpoint . "?calidad=ICECAT")
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
        $this->app->instance('App\Ficha', $this->mock);

        $this->post($this->endpoint, ['ficha' => []])
            ->seeJson([
                'message' => 'Ficha creada exitosamente',
                'ficha'   => 'self'
            ])
            ->assertResponseStatus(201);
    }

    /**
     * @covers ::store
     */
    public function test_POST_store_bad_data() {
        $this->mock
            ->shouldReceive([
                'fill' => Mockery::self(),
                'save' => false
            ])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\Ficha', $this->mock);

        $this->post($this->endpoint, ['ficha' => []])
            ->seeJson([
                'message' => 'Ficha no creada',
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
            'with' => Mockery::self(),
            'find' => Mockery::self(),
            'self' => ['hello']
        ])->withAnyArgs()->once();
        $this->app->instance('App\Ficha', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Ficha obtenido exitosamente',
                'ficha' => ['hello']
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado() {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive([
            'with' => Mockery::self(),
            'find' => false
        ])->withAnyArgs()->once();
        $this->app->instance('App\Ficha', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Ficha no encontrada o no existente',
                'error'   => 'No encontrada'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok() {
        $endpoint = $this->endpoint . '/1';
        $parameters = [
            'ficha'           => [],
            'caracteristicas' => []
        ];

        $this->mock
            ->shouldReceive([
                'find'                      => Mockery::self(),
                'update'                    => true,
                'actualizarCaracteristicas' => true
            ])->withAnyArgs();
        $this->app->instance('App\Ficha', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Ficha se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado() {
        $this->mock
            ->shouldReceive([
                'find' => false,
            ])->withAnyArgs();
        $this->app->instance('App\Ficha', $this->mock);

        $endpoint = $this->endpoint . '/10000';
        $parameters = ['titulo' => 'Hello'];

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la ficha',
                'error'   => 'Ficha no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_error() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['ficha' => []];

        $this->mock
            ->shouldReceive([
                    'find'   => Mockery::self(),
                    'update' => false
                ])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\Ficha', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la ficha',
                'error'   => 'Errors'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::destroy
     */
    public function test_DELETE_destroy_ok() {
        $endpoint = $this->endpoint . '/10';

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'delete' => true])->withAnyArgs();
        $this->app->instance('App\Ficha', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Ficha eliminada correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::destroy
     */
    public function test_DELETE_destroy_not_found() {
        $endpoint = $this->endpoint . '/123456';

        $this->mock
            ->shouldReceive('find')->with(123456)->andReturn(null);
        $this->app->instance('App\Ficha', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la ficha',
                'error'   => 'Ficha no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::destroy
     */
    public function test_DELETE_destroy_bad() {
        $endpoint = $this->endpoint . '/10';

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'delete' => false])->withAnyArgs();
        $this->app->instance('App\Ficha', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la ficha',
                'error'   => 'El metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);
    }

        /**
     * @covers ::fichaCompleta
     */
    public function test_GET_ficha_completa_ok() {
        $endpoint = $this->endpoint . '/completa/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'fichaCompleta' => ['hello']
        ])->withAnyArgs()->once();
        $this->app->instance('App\Ficha', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Ficha obtenida exitosamente',
                'ficha' => ['hello']
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::fichaCompleta
     */
    public function test_GET_ficha_completa_no_encontrado() {
        $endpoint = $this->endpoint . '/completa/10000';

        $this->mock->shouldReceive([
            'find' => false,
        ])->withAnyArgs()->once();
        $this->app->instance('App\Ficha', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Ficha no encontrada o no existente',
                'error'   => 'No encontrada'
            ])
            ->assertResponseStatus(404);

    }

}
