<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\RolController
 */
class RolControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/rol';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Rol');
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
            'all' => 1
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

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
                'save'  => true,
                'self'  => 'self',
                'getId' => 1
            ])
            ->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->post($this->endpoint, ['clave' => 'GERGEN', 'nombre' => 'Gerente General'])
            ->seeJson([
                'message' => 'Rol creado exitosamente',
                'rol'  => 'self'
            ])
            ->assertResponseStatus(201);
    }

    /**
     * @covers ::store
     */
    public function test_POST_store_bad_data() {
        $this->mock
            ->shouldReceive(['fill' => Mockery::self(), 'save' => false])->withAnyArgs();
        $this->mock->errors = ['clave' => 'Clave es requerida'];
        $this->app->instance('App\Rol', $this->mock);

        $this->post($this->endpoint, ['clave' => null, 'nombre' => 'Gerente General'])
            ->seeJson([
                'message' => 'Rol no creado',
                'error'   => ['clave' => 'Clave es requerida']
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_ok() {
        $endpoint = $this->endpoint . '/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'self' => 'self'
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);


        $this->get($endpoint)
            ->seeJson([
                'message' => 'Rol obtenido exitosamente',
                'rol'  => 'self'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::show
     */
    public function test_GET_show_no_encontrado() {
        $endpoint = $this->endpoint . '/10000';

        $this->mock->shouldReceive('find')->with(10000)->andReturn(false);
        $this->app->instance('App\Rol', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'Rol no encontrado o no existente',
                'error'   => 'No encontrado'
            ])
            ->assertResponseStatus(404);

    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['clave' => 'NT'];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => true
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'Rol se actualizo correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_no_encontrado() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['clave' => 'GERGEN'];

        $this->mock->shouldReceive([
            'find' => null,
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del rol',
                'error'   => 'Rol no encontrado'
            ])
            ->assertResponseStatus(404);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_clave_repetida() {
        $endpoint = $this->endpoint . '/1';
        $parameters = ['clave' => 'GERGEN'];

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => false
        ])->withAnyArgs();
        $this->mock->errors = ['clave' => 'La clave ya existe'];
        $this->app->instance('App\Rol', $this->mock);

        $this->put($endpoint, $parameters)
            ->seeJson([
                'message' => 'No se pudo realizar la actualizacion del rol',
                'error'   => ['clave' => 'La clave ya existe']
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
        $this->app->instance('App\Rol', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Rol eliminado correctamente'
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
        $this->app->instance('App\Rol', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el rol',
                'error'   => 'Rol no encontrado'
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
        $this->app->instance('App\Rol', $this->mock);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'No se pudo eliminar el rol',
                'error'   => 'Metodo de eliminar no se pudo ejecutar'
            ])
            ->assertResponseStatus(400);
    }


    /**
     * @covers ::generales
     * @group feature-permisos
     */
    public function testGenerales()
    {
        $endpoint = '/v1/permiso/generales';

        $this->mock->shouldReceive([
            'permisosRoles' => ['controlador' => 'AuthenticateController', 'accion' => 'authenticate']
            ])
            ->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'controlador' => 'AuthenticateController',
                'accion' => 'authenticate'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::individuales
     * @group feature-permisos
     */
    public function testIndividuales()
    {
        $endpoint = '/v1/permiso/individuales';

        $this->mock->shouldReceive([
            'permisosIndividuales' => ['controlador' => 'AuthenticateController', 'accion' => 'authenticate']
            ])
            ->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'controlador' => 'AuthenticateController',
                'accion' => 'authenticate'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::attach
     * @group feature-permisos
     */
    public function testAttachPermisoARol()
    {
        $endpoint = $this->endpoint . '/attach/1/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'permisos->attach' => null
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->permiso = Mockery::mock('App\Permiso');
        $this->permiso->shouldReceive([
            'find' => Mockery::self(),
            'getAttribute' => 1
        ])->withAnyArgs();
        $this->app->instance('App\Permiso', $this->permiso);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Permiso asignado a rol exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::attach
     * @group feature-permisos
     */
    public function testAttachRolNoEncontrado()
    {
        $endpoint = $this->endpoint . '/attach/1/1';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->permiso = Mockery::mock('App\Permiso');
        $this->permiso->shouldReceive([
            'find' => Mockery::self()
        ])->withAnyArgs();
        $this->app->instance('App\Permiso', $this->permiso);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Rol o Permiso no encontrado, intente nuevamente',
                'error' => 'No se asigno permiso a rol'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::attach
     * @group feature-permisos
     */
    public function testAttachPermisoNoEncontrado()
    {
        $endpoint = $this->endpoint . '/attach/1/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'permisos->attach' => null
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->permiso = Mockery::mock('App\Permiso');
        $this->permiso->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Permiso', $this->permiso);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Rol o Permiso no encontrado, intente nuevamente',
                'error' => 'No se asigno permiso a rol'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::detach
     * @group feature-permisos
     */
    public function testDetachPermisoDeRol()
    {
        $endpoint = $this->endpoint . '/detach/1/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'permisos->detach' => 1
            ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->permiso = Mockery::mock('App\Permiso');
        $this->permiso->shouldReceive([
            'find' => Mockery::self(),
            'getAttribute' => 1
        ])->withAnyArgs();
        $this->app->instance('App\Permiso', $this->permiso);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Permiso removido del rol exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::detach
     * @group feature-permisos
     */
    public function testDetachRolNoEncontrado()
    {
        $endpoint = $this->endpoint . '/detach/1/1';

        $this->mock->shouldReceive([
            'find' => false
            ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->permiso = Mockery::mock('App\Permiso');
        $this->permiso->shouldReceive([
            'find' => true
        ])->withAnyArgs();
        $this->app->instance('App\Permiso', $this->permiso);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Rol o Permiso no encontrado, intente nuevamente',
                'error' => 'No se removio permiso del rol'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::detach
     * @group feature-permisos
     */
    public function testDetachPermisoNoEncontrado()
    {
        $endpoint = $this->endpoint . '/detach/1/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'permisos->detach' => 1
            ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->permiso = Mockery::mock('App\Permiso');
        $this->permiso->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Permiso', $this->permiso);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Rol o Permiso no encontrado, intente nuevamente',
                'error' => 'No se removio permiso del rol'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::attachEmpleado
     * @group feature-permisos
     */
    public function testAttachEmpleadoARol()
    {
        $endpoint = $this->endpoint . '/1/empleados/attach/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'empleados->attach' => null
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->empleado = Mockery::mock('App\Empleado');
        $this->empleado->shouldReceive([
            'find' => Mockery::self(),
            'getAttribute' => 1
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->empleado);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Empleado asignado a rol exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::attachEmpleado
     * @group feature-permisos
     */
    public function testAttachEmpleadoRolNoEncontrado()
    {
        $endpoint = $this->endpoint . '/1/empleados/attach/1';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->empleado = Mockery::mock('App\Empleado');
        $this->empleado->shouldReceive([
            'find' => Mockery::self()
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->empleado);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Rol o Empleado no encontrado, intente nuevamente',
                'error' => 'No se asigno empleado a rol'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::attachEmpleado
     * @group feature-permisos
     */
    public function testAttachEmpleadoNoEncontrado()
    {
        $endpoint = $this->endpoint . '/1/empleados/attach/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'empleados->attach' => null
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->empleado = Mockery::mock('App\Empleado');
        $this->empleado->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->empleado);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Rol o Empleado no encontrado, intente nuevamente',
                'error' => 'No se asigno empleado a rol'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::detachEmpleado
     * @group feature-permisos
     */
    public function testDetachEmpleadoDeRol()
    {
        $endpoint = $this->endpoint . '/1/empleados/detach/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'empleados->detach' => 1
            ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->empleado = Mockery::mock('App\Empleado');
        $this->empleado->shouldReceive([
            'find' => Mockery::self(),
            'getAttribute' => 1
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->empleado);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Empleado removido del rol exitosamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::detachEmpleado
     * @group feature-permisos
     */
    public function testDetachEmpleadoRolNoEncontrado()
    {
        $endpoint = $this->endpoint . '/1/empleados/detach/1';

        $this->mock->shouldReceive([
            'find' => false
            ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->empleado = Mockery::mock('App\Empleado');
        $this->empleado->shouldReceive([
            'find' => true
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->empleado);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Rol o Empleado no encontrado, intente nuevamente',
                'error' => 'No se removio empleado del rol'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::detachEmpleado
     * @group feature-permisos
     */
    public function testDetachEmpleadoNoEncontrado()
    {
        $endpoint = $this->endpoint . '/1/empleados/detach/1';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'empleados->detach' => 1
            ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->empleado = Mockery::mock('App\Empleado');
        $this->empleado->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Empleado', $this->empleado);

        $this->delete($endpoint)
            ->seeJson([
                'message' => 'Rol o Empleado no encontrado, intente nuevamente',
                'error' => 'No se removio empleado del rol'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::empleados
     * @group feature-permisos
     */
    public function testObtenerEmpleadosDeRol()
    {
        $endpoint = $this->endpoint . '/1/empleados';

        $this->mock->shouldReceive([
            'find' => Mockery::self(),
            'getAttribute' => []
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'empleados' => []
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::empleados
     * @group feature-permisos
     */
    public function testObtenerEmpleadosDeRolNoExistente()
    {
        $endpoint = $this->endpoint . '/1/empleados';

        $this->mock->shouldReceive([
            'find' => false
        ])->withAnyArgs();
        $this->app->instance('App\Rol', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'message' => 'No se pudo encontrar el rol',
                'error' => 'Rol no existente'
            ])
            ->assertResponseStatus(404);
    }
}
