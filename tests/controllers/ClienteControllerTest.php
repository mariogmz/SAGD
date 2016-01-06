<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\ClienteController
 */
class ClienteControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/cliente';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Cliente');
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
            'get'  => 'success'
        ])->withAnyArgs();
        $this->app->instance('App\Cliente', $this->mock);

        $this->get($this->endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::store
     */
    public function test_POST_store() {
        $this->mock
            ->shouldReceive([
                'fill'  => Mockery::self(),
                'guardar'  => true,
                'self'  => 'self',
                'getId' => 1
            ])
            ->withAnyArgs();
        $this->app->instance('App\Cliente', $this->mock);

        $this->post($this->endpoint, ['clave' => 'ZEG', 'nombre' => 'Zegucom'])
            ->seeJson([
                'message' => 'Cliente creado exitosamente',
                'cliente' => 'self'
            ])
            ->assertResponseStatus(201);
    }

    /**
     * @covers ::store
     */
    public function test_POST_store_bad_data() {
        $this->mock
            ->shouldReceive(['fill' => Mockery::self(), 'guardar' => false])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\Cliente', $this->mock);

        $this->post($this->endpoint, ['clave' => 'Z', 'nombre' => 'Zegucom'])
            ->seeJson([
                'message' => 'Cliente no creado',
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
            'self' => 'Wiu'
        ])->withAnyArgs();
        $this->app->instance('App\Cliente', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Cliente obtenido exitosamente',
                'cliente' => 'Wiu'
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
        ])->withAnyArgs();
        $this->app->instance('App\Cliente', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Cliente no encontrado o no existente',
                'error'   => 'No encontrado'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['nombre' => 'Useless'];

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'actualizar' => true])->withAnyArgs();
        $this->app->instance('App\Cliente', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Cliente se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado() {
        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\Cliente', $this->mock);

        $endpoint = $this->endpoint . '/10000';
        $parameters = ['nombre' => 'PUT'];

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del cliente',
                'error'   => 'Cliente no encontrado'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_clave_repetida() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['clave' => 'Z'];

        $this->mock
            ->shouldReceive(['find' => Mockery::self(), 'actualizar' => false])->withAnyArgs();
        $this->mock->errors = "Errors";
        $this->app->instance('App\Cliente', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del cliente',
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
        $this->app->instance('App\Cliente', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Cliente eliminado correctamente'
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
        $this->app->instance('App\Cliente', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el cliente',
                'error'   => 'Cliente no encontrado'
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
        $this->app->instance('App\Cliente', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el cliente',
                'error'   => 'El metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::buscar
     * @group feature-buscador-clientes
     */
    public function testBuscarClienteConTodosLosParametros()
    {
        $endpoint = '/v1/clientes/buscar/?nombre=A&usuario=A&email=A';

        $this->mock->shouldReceive([
            'where' => Mockery::self(),
            'user' => Mockery::self(),
            'with' => Mockery::self(),
            'get' => [],
        ])->withAnyArgs();
        $this->app->instance('App\Cliente', $this->mock);

        $this->get($endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::buscar
     * @group feature-buscador-clientes
     */
    public function testBuscarClienteSoloPorNombre()
    {
        $endpoint = '/v1/clientes/buscar/?nombre=A&usuario=*&email=*';

        $this->mock->shouldReceive([
            'where' => Mockery::self(),
            'with' => Mockery::self(),
            'get' => []
        ])->withAnyArgs();
        $this->app->instance('App\Cliente', $this->mock);

        $this->get($endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::buscar
     * @group feature-buscador-clientes
     */
    public function testBuscarClienteSoloPorEmail()
    {
        $endpoint = '/v1/clientes/buscar/?nombre=A&usuario=*&email=*';

        $this->mock->shouldReceive([
            'where' => Mockery::self(),
            'with' => Mockery::self(),
            'get' => []
        ])->withAnyArgs();
        $this->app->instance('App\Cliente', $this->mock);

        $this->get($endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::buscar
     * @group feature-buscador-clientes
     */
    public function testBuscarClienteSinEspecificarNinguno()
    {
        $endpoint = '/v1/clientes/buscar/?nombre=*&usuario=*&email=*';

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Debes de especificar al menos un valor de búsqueda',
                'error' => 'Faltan parámetros de búsqueda'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::buscar
     * @group feature-buscador-clientes
     */
    public function testBuscarClienteSinEnviarUnoDeLosParametros()
    {
        $endpoint = '/v1/clientes/buscar/?nombre=A&usuario=A';

        $this->mock->shouldReceive([
            'where' => Mockery::self(),
            'with' => Mockery::self(),
            'get' => []
        ])->withAnyArgs();
        $this->app->instance('App\Cliente', $this->mock);

        $this->get($endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::listar
     */
    public function testListarClientes(){
        $endpoint = '/v1/clientes/listar';

        $this->mock->shouldReceive('whereHas')->withAnyArgs()->andReturn(Mockery::self());
        $this->mock->shouldReceive('get')->with(['id','nombre'])->andReturn('Hello');

        $this->app->instance('App\Cliente', $this->mock);
        $this->get($endpoint)
            ->seeJson([
                'Hello'
            ])->assertResponseOk();
    }
}
