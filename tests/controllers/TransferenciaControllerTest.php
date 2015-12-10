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
            'with->find' => Mockery::self(),
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
            'with->find' => Mockery::self(),
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
            'with->find' => null
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

    /**
     * @covers ::escanear
     */
    public function testPostEscanearExitoso()
    {
        $endpoint = $this->endpoint . '/entradas/1/detalle/1/escanear';
        $data = ['cantidad' => 1];

        $this->mock->shouldReceive([
            'with->find' => Mockery::self(),
            'getAttribute' => Mockery::self(),
            'contains' => Mockery::self(),
            'escanear' => true
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint, $data)
            ->seeJson([
                'message' => 'Producto escaneado exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::escanear
     */
    public function testPostEscanearTransferenciaNoExiste()
    {
        $endpoint = $this->endpoint . '/entradas/1/detalle/1/escanear';
        $data = ['cantidad' => 1];

        $this->mock->shouldReceive([
            'with->find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint, $data)
            ->seeJson([
                'message' => 'La transferencia no pudo ser encontrada o no existe',
                'error' => 'Transferencia no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::escanear
     */
    public function testPostEscanearDetalleNoExiste()
    {
        $endpoint = $this->endpoint . '/entradas/1/detalle/1/escanear';
        $data = ['cantidad' => 1];

        $this->mock->shouldReceive([
            'with->find' => Mockery::self(),
            'getAttribute' => Mockery::self(),
            'contains' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint, $data)
            ->seeJson([
                'message' => 'El detalle de la transferencia no pudo ser encontrada o no existe',
                'error' => 'Transferencia Detalle no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::escanear
     */
    public function testPostEscanearSinParametros()
    {
        $endpoint = $this->endpoint . '/entradas/1/detalle/1/escanear';
        $data = [];

        $this->post($endpoint, $data)
            ->seeJson([
                'message' => 'La peticion va vacia o con datos erroneos',
                'error' => 'Parametros no encontrados'
            ])
            ->assertResponseStatus(422);
    }

    /**
     * @covers ::escanear
     */
    public function testPostEscanearConParametrosIncorrectos()
    {
        $endpoint = $this->endpoint . '/entradas/1/detalle/1/escanear';
        $data = ['cantidades' => 1];

        $this->post($endpoint, $data)
            ->seeJson([
                'message' => 'La peticion va vacia o con datos erroneos',
                'error' => 'Parametros no encontrados'
            ])
            ->assertResponseStatus(422);
    }

    /**
     * @covers ::escanear
     */
    public function testPostEscanearFalla()
    {
        $endpoint = $this->endpoint . '/entradas/1/detalle/1/escanear';
        $data = ['cantidad' => 1];

        $this->mock->shouldReceive([
            'with->find' => Mockery::self(),
            'getAttribute' => Mockery::self(),
            'contains' => Mockery::self(),
            'escanear' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint, $data)
            ->seeJson([
                'message' => 'No se pudo registrar el escaneo del producto, intente nuevamente',
                'error' => 'Producto no escaneado'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::cargandoDestino
     * @group cargandoDestino
     */
    public function testPostCargandoDestinoExitoso()
    {
        $endpoint = $this->endpoint . '/entradas/1/cargando-destino';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'getAttribute' => Mockery::self(),
            'estado_transferencia_id' => 3,
            'setAttribute' => Mockery::self(),
            'save' => true
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'La transferencia cambio de estado a Cargando Destino'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::cargandoDestino
     * @group cargandoDestino
     */
    public function testPostCargandoDestinoNoExiste()
    {
        $endpoint = $this->endpoint . '/entradas/1/cargando-destino';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'La transferencia no fue encontrada o no existe',
                'error' => 'Transferencia no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::cargandoDestino
     * @group cargandoDestino
     */
    public function testPostCargandoDestinoNoGuardada()
    {
        $endpoint = $this->endpoint . '/entradas/1/cargando-destino';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'getAttribute' => Mockery::self(),
            'estado_transferencia_id' => 3,
            'setAttribute' => Mockery::self(),
            'save' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'La transferencia no se pudo cambiar a estado Cargando Destino',
                'error' => 'Transferencia estado no cambio'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::reset
     */
    public function testResetExitoso()
    {
        $endpoint = $this->endpoint . '/entradas/1/detalle/1/reset';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'resetDetalle' => true
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Cantidad escaneada del detalle reseteada exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::reset
     */
    public function testResetTransferenciaNotFound()
    {
        $endpoint = $this->endpoint . '/entradas/1/detalle/1/reset';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'La transferencia no fue encontrada o no existe',
                'error' => 'Transferencia no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::reset
     */
    public function testResetDetalleFails()
    {
        $endpoint = $this->endpoint . '/entradas/1/detalle/1/reset';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'resetDetalle' => false
        ])->withAnyArgs();
        $this->app->instance('App\Transferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'No se pudo resetear la cantidad escaneada del detalle',
                'error' => 'Cantidad escaneada no reseteada'
            ])
            ->assertResponseStatus(400);
    }
}
