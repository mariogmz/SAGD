<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\EmpleadoController
 */
class EmpleadoControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/empleado';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Empleado');
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
     * @group con-sucursal
     */
    public function test_GET_index() {
        $this->mock
            ->shouldReceive([
                'with' => Mockery::self(),
                'get' => '[{"id":1,"nombre":"Administrador","usuario":"admin","activo":1,"puesto":"Administrador","fecha_cambio_password":"2015-10-20 17:07:54","fecha_ultimo_ingreso":null,"sucursal_id":1}]'])
            ->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $this->get($this->endpoint)
            ->seeJson([
                'usuario' => 'admin'
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
                'guardar'  => Mockery::self(),
                'self'  => 'self',
                'getId' => 1
            ])
            ->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $params = ['usuario' => 'ogarcia', 'datos_contacto' => ['email' => 'ogarcia@zegucom.com.mx']];

        $this->post($this->endpoint, $params)
            ->seeJson([
                'message' => 'Empleado creado exitosamente',
                'empleado'  => 'self'
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
                'guardar' => false
            ])
            ->withAnyArgs();
        $this->mock->errors = ['usuario' => 'Null'];
        $this->app->instance('App\Empleado', $this->mock);

        $params = ['usuario' => 'ogarcia', 'datos_contacto' => ['email' => 'ogarcia@zegucom.com.mx']];

        $this->post($this->endpoint, $params)
            ->seeJson([
                'message' => 'Empleado no creado',
                'error'   => ['usuario' => 'Null']
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
        $this->app->instance('App\Empleado', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'Empleado obtenido exitosamente',
                'empleado'  => 'self'
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
                'find' => false
            ]);
        $this->app->instance('App\Empleado', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Empleado no encontrado o no existente',
                'error'   => 'No encontrado'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['nombre' => 'Barry'];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'actualizar' => true
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Empleado se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['nombre' => 'Administrador'];

        $this->mock->shouldReceive([
            'find' => null,
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del empleado',
                'error'   => 'Empleado no encontrado'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_fail() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['nombre' => 'Administrador'];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'actualizar' => false,
            'update' => false
        ])->withAnyArgs();
        $this->mock->errors = ['empleado' => 'Invalido'];
        $this->app->instance('App\Empleado', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del empleado',
                'error'   => ['empleado' => 'Invalido']
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
        $this->app->instance('App\Empleado', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Empleado eliminado correctamente'
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
        $this->app->instance('App\Empleado', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el empleado',
                'error'   => 'Empleado no encontrado'
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
        $this->app->instance('App\Empleado', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el empleado',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::store
     * @group datos-contacto
     */
    public function test_POST_con_parametros_de_datos_de_contacto()
    {
        $this->mock
            ->shouldReceive([
                'fill'      => Mockery::self(),
                'guardar'   => true,
                'self'      => 'self',
                'getId'     => 1
            ])
            ->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $params = ['usuario' => 'ogarcia', 'datos_contacto' => ['email' => 'ogarcia@zegucom.com.mx']];

        $this->post($this->endpoint, $params)
            ->seeJson([
                'message' => 'Empleado creado exitosamente',
                'empleado'  => 'self'
            ])
            ->assertResponseStatus(201);
    }

    /**
     * @covers ::update
     * @group datos-contacto
     */
    public function test_PUT_con_parametros_de_datos_de_contacto()
    {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['nombre' => 'Barry', 'datos_contacto' => ['telefono' => '45185']];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'actualizar' => true,
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Empleado se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::store
     * @group datos-contacto
     */
    public function test_POST_tiene_que_llevar_datos_contacto()
    {
        $this->mock
            ->shouldReceive([
                'fill'      => Mockery::self(),
                'guardar'   => Mockery::self(),
                'self'      => 'self',
                'getId'     => 1
            ])
            ->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $params = ['usuario' => 'ogarcia'];

        $this->post($this->endpoint, $params)
            ->seeJson([
                'message' => 'Empleado no creado'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::index
     * @group con-sucursal
     */
    public function test_GET_index_de_una_sucursal()
    {
        $this->app->instance('App\Empleado', $this->mock);

        $this->mock
            ->shouldReceive([
                'where' => Mockery::self(),
                'get' => '[{"id":1,"nombre":"Administrador","usuario":"admin","activo":1,"puesto":"Administrador","fecha_cambio_password":"2015-10-20 17:07:54","fecha_ultimo_ingreso":null,"sucursal_id":1}]'
            ])
            ->withAnyArgs();

        $this->get($this->endpoint . "?sucursal=1")
            ->seeJson([
                'usuario' => 'admin'
            ])
            ->assertResponseStatus(200);
    }

        /**
     * @covers ::attach
     * @group feature-permisos
     */
    public function testAttachRolAEmpleado()
    {
        $endpoint = $this->endpoint . '/1/roles/attach/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'roles->attach' => null
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $this->permiso = Mockery::mock('App\Rol');
        $this->permiso->shouldReceive([
            'find' => Mockery::self(),
            'getAttribute' => 1
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->permiso);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Rol asignado a empleado exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::attach
     * @group feature-permisos
     */
    public function testAttachEmpleadoNoEncontrado()
    {
        $endpoint = $this->endpoint . '/1/roles/attach/1';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $this->permiso = Mockery::mock('App\Rol');
        $this->permiso->shouldReceive([
            'find' => Mockery::self()
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->permiso);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Rol o Empleado no encontrado, intente nuevamente',
                'error' => 'No se asigno rol a empleado'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::attach
     * @group feature-permisos
     */
    public function testAttachRolNoEncontrado()
    {
        $endpoint = $this->endpoint . '/1/roles/attach/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'roles->attach' => null
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $this->permiso = Mockery::mock('App\Rol');
        $this->permiso->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->permiso);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Rol o Empleado no encontrado, intente nuevamente',
                'error' => 'No se asigno rol a empleado'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::detach
     * @group feature-permisos
     */
    public function testDetachRolDelEmpleado()
    {
        $endpoint = $this->endpoint . '/1/roles/detach/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'roles->detach' => 1
            ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $this->permiso = Mockery::mock('App\Rol');
        $this->permiso->shouldReceive([
            'find' => Mockery::self(),
            'getAttribute' => 1
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->permiso);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Rol removido del empleado exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::detach
     * @group feature-permisos
     */
    public function testDetachEmpleadoNoEncontrado()
    {
        $endpoint = $this->endpoint . '/1/roles/detach/1';

        $this->mock->shouldReceive([
            'find' => false
            ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $this->permiso = Mockery::mock('App\Rol');
        $this->permiso->shouldReceive([
            'find' => true
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->permiso);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Rol o Empleado no encontrado, intente nuevamente',
                'error' => 'No se removio el rol del empleado'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::detach
     * @group feature-permisos
     */
    public function testDetachRolNoEncontrado()
    {
        $endpoint = $this->endpoint . '/1/roles/detach/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'roles->detach' => 1
            ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->mock);

        $this->permiso = Mockery::mock('App\Rol');
        $this->permiso->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->permiso);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Rol o Empleado no encontrado, intente nuevamente',
                'error' => 'No se removio el rol del empleado'
            ])
            ->assertResponseStatus(400);
    }
}
