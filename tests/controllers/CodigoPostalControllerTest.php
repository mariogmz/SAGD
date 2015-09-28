<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\CodigoPostalController
 */
class CodigoPostalControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/codigo-postal';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\CodigoPostal');
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
            ->shouldReceive('all')
            ->once()
            ->andReturn('[{"id":1,"estado":"Distrito Federal","municipio":"Alvaro Obregon","codigo_postal":"01000","deleted_at":null}]');
        $this->app->instance('App\CodigoPostal', $this->mock);

        $this->get($this->endpoint)
            ->seeJson([
                'estado' => 'Distrito Federal',
                'codigo_postal' => '01000'
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
        $this->app->instance('App\CodigoPostal', $this->mock);

        $this->post($this->endpoint, ['estado' => 'Aguascalientes', 'codigo_postal' => '20110'])
            ->seeJson([
                'message' => 'Codigo Postal agregado exitosamente',
                'codigo_postal'  => 'self'
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
        $this->mock->errors = ['codigo_postal' => 'Codigo postal'];
        $this->app->instance('App\CodigoPostal', $this->mock);

        $this->post($this->endpoint, ['codigo_postal' => null])
            ->seeJson([
                'message' => 'Codigo Postal no creado',
                'error'   => ['codigo_postal' => 'Codigo postal']
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
                'find' => Mockery::self(),
                'self' => 'self'
            ])
            ->withAnyArgs();
        $this->app->instance('App\CodigoPostal', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'Codigo Postal obtenido exitosamente',
                'codigo_postal'  => 'self'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado() {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\CodigoPostal', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Codigo Postal no encontrado o no existente',
                'error'   => 'No encontrado'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['codigo_postal' => '01001'];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => true
        ])->withAnyArgs();
        $this->app->instance('App\CodigoPostal', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Codigo Postal se actualizo correctamente'
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
        $this->app->instance('App\CodigoPostal', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del codigo postal',
                'error'   => 'Codigo Postal no encontrado'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_fail() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['codigo_postal' => '01000'];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => false
        ])->withAnyArgs();
        $this->mock->errors = ['codigo_postal' => 'Codigo Postal es invalido'];
        $this->app->instance('App\CodigoPostal', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del codigo postal',
                'error'   => ['codigo_postal' => 'Codigo Postal es invalido']
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
        $this->app->instance('App\CodigoPostal', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Codigo Postal eliminado correctamente'
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
        $this->app->instance('App\CodigoPostal', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el codigo postal',
                'error'   => 'Codigo Postal no encontrado'
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
        $this->app->instance('App\CodigoPostal', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el codigo postal',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);

    }
}
