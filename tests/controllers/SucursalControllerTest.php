<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\SucursalController
 */
class SucursalControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/sucursal';

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Sucursal');
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
        $this->mock
            ->shouldReceive('all')
            ->once()
            ->andReturn('[{"id":1,"clave":"DICOTAGS","nombre":"Dicotech Aguascalientes","horarios":"Lunes a Viernes de 9:00am a 6:30pm, Sabados de 9:00am a 2:30pm","ubicacion":null,"proveedor_id":1,"domicilio_id":1,"deleted_at":null}]');
        $this->app->instance('App\Sucursal', $this->mock);

        $this->get($this->endpoint)
            ->seeJson([
                'clave' => 'DICOTAGS',
                'nombre' => 'Dicotech Aguascalientes'
            ])
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
        $this->app->instance('App\Sucursal', $this->mock);

        $this->post($this->endpoint, ['clave' => 'DICOTECH', 'nombre' => 'Dicotech Aguascalientes'])
            ->seeJson([
                'message' => 'Sucursal creada exitosamente',
                'sucursal' => 'self'
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
        $this->app->instance('App\Sucursal', $this->mock);

        $this->post($this->endpoint, ['clave' => 'DICOTECH', 'nombre' => 'Dicotech Aguascalientes'])
            ->seeJson([
                'message' => 'Sucursal no creada',
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
        $this->app->instance('App\Sucursal', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'Sucursal obtenida exitosamente'
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
        $this->app->instance('App\Sucursal', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Sucursal no encontrada o no existente',
                'error' => 'No encontrada'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok()
    {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['nombre' => 'Useless'];

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'update' => true])->withAnyArgs();
        $this->app->instance('App\Sucursal', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Sucursal se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado()
    {
        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\Sucursal', $this->mock);

        $endpoint = $this->endpoint . '/10000';
        $parameters = ['razon_social' => 'PUT'];

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la Sucursal',
                'error' => 'Sucursal no encontrada'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_clave_repetida()
    {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['clave' => 'DICOTECH'];

        $this->mock
            ->shouldReceive([
                'find' => Mockery::self(),
                'update' => false
            ])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\Sucursal', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion de la Sucursal',
                'error' => 'Errors'
            ])
            ->assertResponseStatus(400);
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
        $this->app->instance('App\Sucursal', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Sucursal eliminada correctamente'
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
        $this->app->instance('App\Sucursal', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la sucursal',
                'error'   => 'Sucursal no encontrada'
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
        $this->app->instance('App\Sucursal', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar la sucursal',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);

    }
}
