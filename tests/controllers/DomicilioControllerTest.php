<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\DomicilioController
 */
class DomicilioControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/domicilio';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Domicilio');
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
                'get' => '[{"id":1,"calle":"Av. de la Convenci\u00f3n de 1914 Norte #502, Col. Morelos","localidad":"Aguascalientes","codigo_postal_id":1435,"deleted_at":null,"codigo_postal":{"id":1435,"estado":"Aguascalientes","municipio":"Aguascalientes","codigo_postal":"20140","deleted_at":null},"telefonos":[{"id":1,"numero":"4499967409","tipo":"Trabajo","domicilio_id":1,"deleted_at":null}]}]'
            ]);
        $this->app->instance('App\Domicilio', $this->mock);

        $this->get($this->endpoint)
            ->seeJson([
                'localidad' => 'Aguascalientes',
                'codigo_postal' => '20140',
                'numero' => '4499967409'
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
        $this->app->instance('App\Domicilio', $this->mock);

        $this->post($this->endpoint, ['localidad' => 'Aguascalientes', 'calle' => 'NA'])
            ->seeJson([
                'message' => 'Domicilio agregado exitosamente',
                'domicilio'  => 'self'
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
        $this->mock->errors = ['localidad' => 'Null'];
        $this->app->instance('App\Domicilio', $this->mock);

        $this->post($this->endpoint, ['localidad' => null])
            ->seeJson([
                'message' => 'Domicilio no creado',
                'error'   => ['localidad' => 'Null']
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
        $this->app->instance('App\Domicilio', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'Domicilio obtenido exitosamente',
                'domicilio'  => 'self'
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
        $this->app->instance('App\Domicilio', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Domicilio no encontrado o no existente',
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
        $this->app->instance('App\Domicilio', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Domicilio se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['codigo_postal' => '01001'];

        $this->mock->shouldReceive([
            'find' => null,
        ])->withAnyArgs();
        $this->app->instance('App\Domicilio', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del domicilio',
                'error'   => 'Domicilio no encontrado'
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
        $this->mock->errors = ['domicilio' => 'Invalido'];
        $this->app->instance('App\Domicilio', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del domicilio',
                'error'   => ['domicilio' => 'Invalido']
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
        $this->app->instance('App\Domicilio', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Domicilio eliminado correctamente'
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
        $this->app->instance('App\Domicilio', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el domicilio',
                'error'   => 'Domicilio no encontrado'
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
        $this->app->instance('App\Domicilio', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el domicilio',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);
    }
}
