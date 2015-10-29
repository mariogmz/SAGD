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
     * @group bases
     */
    public function test_GET_index()
    {
        $this->mock
            ->shouldReceive([
                'with' => Mockery::self(),
                'get' => '[{"id":1,"clave":"DICOTECH","nombre":"Dicotech Aguascalientes","horarios":"Lunes a Viernes de 9:00am a 6:30pm, Sabados de 9:00am a 2:30pm","ubicacion":null,"proveedor_id":1,"domicilio_id":1,"deleted_at":null,"proveedor":{"id":1,"clave":"DICO","razon_social":"DICOTECH MAYORISTA DE TECNOLOGIA S.A. DE C.V.","externo":0,"pagina_web":"http:\/\/www.dicotech.com.mx","deleted_at":null},"domicilio":{"id":1,"calle":"Av. de la Convenci\u00f3n de 1914 Norte #502, Col. Morelos","localidad":"Aguascalientes","codigo_postal_id":1435,"deleted_at":null}}]']);
        $this->app->instance('App\Sucursal', $this->mock);

        $this->get($this->endpoint)
            ->seeJson([
                'clave' => 'DICOTECH',
                'nombre' => 'Dicotech Aguascalientes',
                'externo' => 0,
                'localidad' => 'Aguascalientes',
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::index
     * @group bases
     */
    public function test_GET_index_with_parameters()
    {
        $endpoint = $this->endpoint . '?base=true';
        $this->mock
            ->shouldReceive([
                'with' => Mockery::self(),
                'get' => '[{"id": 1,"clave": "DICOTAGS","nombre": "Dicotech Aguascalientes","horarios": "Lunes a Viernes de 9:00am a 6:30pm, Sábados de 9:00am a 2:30pm","ubicacion": null,"proveedor_id": 1,"domicilio_id": 1}]'
            ]);
        $this->app->instance('App\Sucursal', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'clave' => 'DICOTAGS'
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
                'guardar' => true,
                'self' => 'self',
                'getId' => 1
            ])
            ->withAnyArgs();
        $this->app->instance('App\Sucursal', $this->mock);

        $this->post($this->endpoint, ['clave' => 'DICOTECH', 'nombre' => 'Dicotech Aguascalientes', 'base_id' => 1])
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
            ->shouldReceive(['fill' => Mockery::self(), 'guardar' => false])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\Sucursal', $this->mock);

        $this->post($this->endpoint, ['clave' => 'DICOTECH', 'nombre' => 'Dicotech Aguascalientes', 'base_id' => 1])
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

        $this->mock
            ->shouldReceive([
                'with' => Mockery::self(),
                'find' => true
            ])
            ->withAnyArgs();
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

        $this->mock
            ->shouldReceive([
                'with' => Mockery::self(),
                'find' => false
            ])
            ->withAnyArgs();
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

    /**
     * @covers ::index
     * @group url-parameters
     */
    public function testIndexConParametros()
    {
        $endpoint = $this->endpoint . '?proveedor_clave=DICO';

        $this->get($endpoint)
            ->seeJson([
                "id"=> 1, "clave"=> "DICOTAGS", "nombre"=> "Dicotech Aguascalientes",
                "id"=> 2, "clave"=> "DICOLEON", "nombre"=> "Dicotech León",
                "id"=> 3, "clave"=> "ZEGUCZAC", "nombre"=> "Zegucom Zacatecas",
                "id"=> 4, "clave"=> "ZEGUCARB", "nombre"=> "Zegucom Arboledas",
            ])
            ->assertResponseStatus(200);
    }
}
