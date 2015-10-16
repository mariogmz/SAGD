<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\ProveedorController
 */
class ProveedorControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/proveedor';

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Proveedor');
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
            ->shouldReceive('all')
            ->once()
            ->andReturn('[{"id": 1,"clave": "DICO","razon_social": "DICOTECH MAYORISTA DE TECNOLOGIA S.A. DE C.V.","externo": 0,"pagina_web": "http://www.dicotech.com.mx"},{"id": 2,"clave": "CADTON","razon_social": "COMPUTACION ADMINISTRATIVA Y DISEÑO, S.A. DE C.V.","externo": 1,"pagina_web": "http://www.cadtoner.com.mx"},{"id": 3,"clave": "INGRAM","razon_social": "INGRAM MICRO MEXICO S.A. DE C.V.","externo": 1,"pagina_web": "http://HTTP://WWW.INGRAMMIC"}]');
        $this->app->instance('App\Proveedor', $this->mock);

        $this->get($this->endpoint)
            ->seeJson([
                'clave' => 'DICO',
                'clave' => 'INGRAM',
                'clave' => 'CADTON'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::index
     * @group bases
     */
    public function test_GET_index_with_params()
    {
        $endpoint = $this->endpoint . '?base=true';
        $this->mock
            ->shouldReceive([
                'has' => Mockery::self(),
                'get' => '[{"id": 1,"clave": "DICO","razon_social": "DICOTECH MAYORISTA DE TECNOLOGIA S.A. DE C.V.","externo": 0,"pagina_web": "http://www.dicotech.com.mx"},{"id": 3,"clave": "INGRAM","razon_social": "INGRAM MICRO MEXICO S.A. DE C.V.","externo": 1,"pagina_web": "http://HTTP://WWW.INGRAMMIC"}]'
            ])
            ->once();
        $this->app->instance('App\Proveedor', $this->mock);

        $this->get($endpoint)
            ->seeJsonEquals([["id" => 1,"clave" => "DICO","razon_social" => "DICOTECH MAYORISTA DE TECNOLOGIA S.A. DE C.V.","externo" => 0,"pagina_web" => "http://www.dicotech.com.mx"],["id" => 3,"clave" => "INGRAM","razon_social" => "INGRAM MICRO MEXICO S.A. DE C.V.","externo" => 1,"pagina_web" => "http://HTTP://WWW.INGRAMMIC"]])
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
        $this->app->instance('App\Proveedor', $this->mock);

        $this->post($this->endpoint, ['clave' => 'DICO', 'razon_social' => 'DICOTECH MAYORISTA DE TECNOLOGIA'])
            ->seeJson([
                'message' => 'Proveedor creado exitosamente',
                'proveedor' => 'self'
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
        $this->app->instance('App\Proveedor', $this->mock);

        $this->post($this->endpoint, ['clave' => 'DICO', 'razon_social' => 'DICOTECH MAYORISTA DE TECNOLOGIA'])
            ->seeJson([
                'message' => 'Proveedor no creado',
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
        $this->app->instance('App\Proveedor', $this->mock);


        $this->get($endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado()
    {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\Proveedor', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Proveedor no encontrado o no existente',
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
        $parameters = ['razon_social' => 'Useless'];

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'update' => true])->withAnyArgs();
        $this->app->instance('App\Proveedor', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Proveedor se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado()
    {
        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\Proveedor', $this->mock);

        $endpoint = $this->endpoint . '/10000';
        $parameters = ['razon_social' => 'PUT'];

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del Proveedor',
                'error' => 'Proveedor no encontrado'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_clave_repetida()
    {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['clave' => 'DICO'];

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'update' => false])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\Proveedor', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del Proveedor',
                'error' => 'Errors'
            ])
            ->assertResponseStatus(400);
    }

}
