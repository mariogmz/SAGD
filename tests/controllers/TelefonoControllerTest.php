<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\TelefonoController
 */
class TelefonoControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/telefono';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Telefono');
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
        $this->mock
            ->shouldReceive([
                'with' => Mockery::self(),
                'get' => '[{"id": 1,"numero": "4499967409","tipo": "Trabajo","domicilio_id": 1,"deleted_at": null,"domicilio": {"id": 1,"calle": "Av. de la Convención de 1914 Norte #502, Col. Morelos","localidad": "Aguascalientes","codigo_postal_id": 1435,"deleted_at": null,"codigo_postal": {"id": 1435,"estado": "Aguascalientes","municipio": "Aguascalientes","codigo_postal": "20140","deleted_at": null}}}]'
            ]);
        $this->app->instance('App\Telefono', $this->mock);

        $this->get($this->endpoint)
            ->seeJson([
                'numero' => '4499967409',
                'localidad' => 'Aguascalientes',
                'codigo_postal' => '20140'
            ])
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
        $this->app->instance('App\Telefono', $this->mock);

        $this->post($this->endpoint, ['numero' => '4491234567'])
            ->seeJson([
                'message' => 'Teléfono agregado exitosamente',
                'telefono'  => 'self'
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
            ])
            ->withAnyArgs();
        $this->mock->errors = ['numero' => 'Null'];
        $this->app->instance('App\Telefono', $this->mock);

        $this->post($this->endpoint, ['numero' => null])
            ->seeJson([
                'message' => 'Teléfono no creado',
                'error'   => ['numero' => 'Null']
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_ok() {
        $endpoint = $this->endpoint . '/1';

        $this->mock
            ->shouldReceive([
                'with' => Mockery::self(),
                'find' => Mockery::self(),
                'self' => 'self'
            ])
            ->withAnyArgs();
        $this->app->instance('App\Telefono', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'Teléfono obtenido exitosamente',
                'telefono'  => 'self'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado() {
        $endpoint = $this->endpoint . '/10000';

        $this->mock
            ->shouldReceive([
                'with' => Mockery::self(),
                'find' => false]);
        $this->app->instance('App\Telefono', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Teléfono no encontrado o no existente',
                'error'   => 'No encontrado'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['calle' => null];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => true
        ])->withAnyArgs();
        $this->app->instance('App\Telefono', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Teléfono se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['numero' => '01001'];

        $this->mock->shouldReceive([
            'find' => null,
        ])->withAnyArgs();
        $this->app->instance('App\Telefono', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del telefono',
                'error'   => 'Teléfono no encontrado'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_fail() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['calle' => null];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => false
        ])->withAnyArgs();
        $this->mock->errors = ['telefono' => 'Invalido'];
        $this->app->instance('App\Telefono', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del telefono',
                'error'   => ['telefono' => 'Invalido']
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
        $this->app->instance('App\Telefono', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Teléfono eliminado correctamente'
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
        $this->app->instance('App\Telefono', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el telefono',
                'error'   => 'Teléfono no encontrado'
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
        $this->app->instance('App\Telefono', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el telefono',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);
    }
}
