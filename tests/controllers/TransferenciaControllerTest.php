<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\TransferenciaController
 */
class TransferenciaControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/transferencias';

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Transferencia');
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
     * @covers ::indexSalidas
     */
    public function test_get_index_salidas()
    {
        $endpoint = $this->endpoint . '/salidas';

        $this->user = $this->setUpMock('App\User');
        $this->user->shouldReceive([
            'getAttribute' => Mockery::self(),
            'setAttribute' => Mockery::self(),
            'morphable' => Mockery::self(),
            'sucursal_id' => 1
            ])
        ->withAnyArgs();
        $this->app->instance('App\User', $this->user);

        JWTAuth::shouldReceive([
            'parseToken->authenticate' => $this->user,
        ]);

        $this->mock->shouldReceive([
            'where->get' => []
            ])
            ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->get($endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::indexEntradas
     */
    public function test_get_index_entradas()
    {
        $endpoint = $this->endpoint . '/entradas';

        $this->user = $this->setUpMock('App\User');
        $this->user->shouldReceive([
            'getAttribute' => Mockery::self(),
            'setAttribute' => Mockery::self(),
            'morphable' => Mockery::self(),
            'sucursal_id' => 1
            ])
        ->withAnyArgs();
        $this->app->instance('App\User', $this->user);

        JWTAuth::shouldReceive([
            'parseToken->authenticate' => $this->user,
        ]);

        $this->mock->shouldReceive([
            'where->get' => []
            ])
            ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->get($endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::indexSalidas
     */
    public function test_get_index_salidas_sin_empleado()
    {
        $endpoint = $this->endpoint . '/salidas';

        JWTAuth::shouldReceive([
            'parseToken->authenticate' => null,
        ]);

        $this->mock->shouldReceive([
            'where->get' => []
            ])
            ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'El empleado no se encontro',
                'error' => 'No se pudo encontrar el empleado que realizo esta peticion'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::indexEntradas
     */
    public function test_get_index_entradas_sin_empleado()
    {
        $endpoint = $this->endpoint . '/entradas';

        JWTAuth::shouldReceive([
            'parseToken->authenticate' => null,
        ]);

        $this->mock->shouldReceive([
            'where->get' => []
            ])
            ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'El empleado no se encontro',
                'error' => 'No se pudo encontrar el empleado que realizo esta peticion'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::create
     */
    public function test_post_create()
    {
        $endpoint = $this->endpoint . '/salidas/crear';

        $this->mock->shouldReceive([
            'fill' => Mockery::self(),
            'save' => true,
            'self' => [],
            'getId' => 1
            ])
        ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Transferencia pre-guardada exitosamente',
                'transferencia' => []
            ])
            ->assertResponseStatus(201);
    }

    /**
     * @covers ::create
     */
    public function test_post_create_fail()
    {
        $endpoint = $this->endpoint . '/salidas/crear';

        $this->mock->shouldReceive([
            'fill' => Mockery::self(),
            'save' => false
            ])
        ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Transferencia no creada',
                'error' => 'La transferencia no pudo ser pre-guardada'
            ])
            ->assertResponseStatus(400);
    }
}
