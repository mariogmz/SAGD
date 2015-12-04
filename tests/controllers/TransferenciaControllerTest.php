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
            'with->where->get' => []
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
            'with->where->get' => []
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

    /**
     * @covers ::show
     */
    public function test_get_show_salida()
    {
        $endpoint = $this->endpoint . '/salidas/ver/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'self' => []
            ])
        ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Transferencia obtenida exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::entrada
     */
    public function test_get_show_entrada()
    {
        $endpoint = $this->endpoint . '/entradas/ver/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'self' => []
            ])
        ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Transferencia obtenida exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_get_show_fail()
    {
        $endpoint = $this->endpoint . '/salidas/ver/1000';

        $this->mock->shouldReceive([
            'find' => null
            ])
        ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Transferencia no encontrada o no existente',
                'error' => 'La transferencia no pudo ser encontrada. Quizas no existe'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_put_update()
    {
        $endpoint = $this->endpoint . '/salidas/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'update' => true,
            'self' => []
            ])
        ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->put($endpoint)
            ->seeJson([
                'message' => 'Transferencia se actualizo correctamente',
                'transferencia' => []
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_put_find_fail()
    {
        $endpoint = $this->endpoint . '/salidas/1';

        $this->mock->shouldReceive([
            'find' => null
            ])
        ->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->put($endpoint)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la transferencia',
                'error' => 'Transferencia no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_put_update_fail()
    {
        $endpoint = $this->endpoint . '/salidas/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'update' => false,
            'getAttribute' => Mockery::self(),
            'errors' => []
            ])
        ->withAnyArgs();
        $this->mock->errors = [];
        $this->app->instance('App\Transferencia', $this->mock);

        $this->put($endpoint)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la transferencia',
                'error' => []
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::destroy
     */
    public function test_delete_transferencia()
    {
        $endpoint = $this->endpoint . '/eliminar/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'delete' => true
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Transferencia eliminada correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::destroy
     */
    public function test_delete_transferencia_find_fail()
    {
        $endpoint = $this->endpoint . '/eliminar/1';

        $this->mock->shouldReceive([
            'find' => null
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la transferencia',
                'error' => 'Transferencia no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::destroy
     */
    public function test_delete_transferencia_delete_fail()
    {
        $endpoint = $this->endpoint . '/eliminar/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'delete' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la transferencia',
                'error' => 'El metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::saveDetalle
     */
    public function testPostSaveDetalle()
    {
        $endpoint = $this->endpoint . '/salidas/1/detalle';
        $params = [];

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'agregarDetalle' => ['a']
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint, $params)
            ->seeJson([
                'message' => 'Detalle agregado a la transferencia exitosamente',
                'detalle' => ['a']
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::saveDetalle
     */
    public function testPostSaveDetalleFindFails()
    {
        $endpoint = $this->endpoint . '/salidas/1/detalle';
        $params = [];

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint, $params)
            ->seeJson([
                'message' => 'No se pudo encontrar la transferencia',
                'error' => 'Transferencia no existente'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::saveDetalle
     */
    public function testPostSaveDetalleAgregarDetalleFails()
    {
        $endpoint = $this->endpoint . '/salidas/1/detalle';
        $params = [];

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'agregarDetalle' => null
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint, $params)
            ->seeJson([
                'message' => 'Detalle no se pudo agregar a la transferencia',
                'error' => 'Detalle no creado'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::unsaveDetalle
     */
    public function testDeleteUnsaveDetalle()
    {
        $endpoint = $this->endpoint . '/salidas/1/detalle/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'quitarDetalle' => true
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Detalle removido de la transferencia exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::unsaveDetalle
     */
    public function testDeleteUnsaveDetalleFindFails()
    {
        $endpoint = $this->endpoint . '/salidas/1/detalle/1';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo encontrar la transferencia',
                'error' => 'Transferencia no existente'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::unsaveDetalle
     */
    public function testDeleteUnsaveDetalleQuitarDetalleFails()
    {
        $endpoint = $this->endpoint . '/salidas/1/detalle/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'quitarDetalle' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Detalle no se pudo remover de la transferencia',
                'error' => 'Detalle no removido'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::transferir
     */
    public function testPostTransferir()
    {
        $endpoint = $this->endpoint . '/salidas/transferir/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'transferir' => true
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Transferencia registrada y en progreso'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::transferir
     */
    public function testPostTransferirFindFails()
    {
        $endpoint = $this->endpoint . '/salidas/transferir/1';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'No se pudo encontrar la transferencia',
                'error' => 'Transferencia no existente'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::transferir
     */
    public function testPostTransferirFails()
    {
        $endpoint = $this->endpoint . '/salidas/transferir/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'transferir' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Transferencia no se marco como transferida',
                'error' => 'Ocurrio un error interno. Existencias no se modificaron'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::cargar
     */
    public function testPostCargar()
    {
        $endpoint = $this->endpoint . '/entradas/cargar/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'cargar' => true
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Transferencia cargada'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::cargar
     */
    public function testPostCargarFindFails()
    {
        $endpoint = $this->endpoint . '/entradas/cargar/1';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'No se pudo encontrar la transferencia',
                'error' => 'Transferencia no existente'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::cargar
     */
    public function testPostCargarFails()
    {
        $endpoint = $this->endpoint . '/entradas/cargar/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'cargar' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Transferencia no se marco como cargada',
                'error' => 'Ocurrio un error interno. Existencias no se modificaron'
            ])
            ->assertResponseStatus(400);
    }
}
