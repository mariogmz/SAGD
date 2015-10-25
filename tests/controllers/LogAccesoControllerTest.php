<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\AuthenticateController
 */
class LogAccesoControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/authenticate';

    public function setUp() {
        parent::setUp();
        $this->user = $this->setUpMock('App\User');
        $this->empleado = $this->setUpMock('App\Empleado');
        $this->mock = $this->setUpMock('App\LogAcceso');

        App\LogAcceso::all()->each(function($log){
            $log->forceDelete();
        });
    }

    public function setUpMock($class) {
        $mock = Mockery::mock($class);
        return $mock;
    }

    public function tearDown() {
        Mockery::close();
    }

    /**
     * @covers ::intentoDeLogin
     */
    public function testIntentoFallidoRegistraUnLogAcceso()
    {
        JWTAuth::shouldReceive([
            'attempt' => null
            ])
            ->once()
            ->withAnyArgs();

        $this->post($this->endpoint, ['email' => 'ogarcia@zegucom.com.mx', 'password' => 'hello']);

        $user = App\User::whereEmail('ogarcia@zegucom.com.mx')->first();
        $empleado = $user->morphable;
        $this->assertNotNull($empleado->logsAccesos->last());
        $this->assertEquals(0, $empleado->logsAccesos->last()->exitoso);
    }

    /**
     * @covers ::intentoDeLogin
     */
    public function testIntentoExitosoRegistraUnLogAcceso()
    {
        JWTAuth::shouldReceive([
            'attempt' => 'abcd',
            'toUser' => $this->user
            ])
            ->withAnyArgs();

        $this->user->shouldReceive([
            'morphable->user' => Mockery::self(),
            'morphable' => App\Empleado::whereUsuario('ogarcia')->first(),
            'getAttribute' => App\Empleado::whereUsuario('ogarcia')->first()
            ])
            ->withAnyArgs();
        $this->app->instance('App\User', $this->user);

        $this->post($this->endpoint, ['email' => 'ogarcia@zegucom.com.mx', 'password' => 'hello']);

        $user = App\User::whereEmail('ogarcia@zegucom.com.mx')->first();
        $empleado = $user->morphable;
        $this->assertNotNull($empleado->logsAccesos->last());
        $this->assertEquals(1, $empleado->logsAccesos->last()->exitoso);
    }

    /**
     * @covers ::index
     * @group logs-controller
     */
    public function test_GET_index()
    {
        $endpoint = '/v1/logs-acceso';

        $this->mock->shouldReceive([
            'with' => Mockery::self(),
            'get' => '[{"id":1,"exitoso":1,"created_at":"2015-10-24 16:55:44","updated_at":"2015-10-24 16:55:44","empleado_id":2,"empleado":{"id":2,"nombre":"Omar Garcia","usuario":"ogarcia","activo":1,"puesto":"Administrador","fecha_cambio_password":"2015-10-24 18:25:35","fecha_ultimo_ingreso":"2015-10-24 16:46:12","sucursal_id":1}}]'
            ])
            ->withAnyArgs();
        $this->app->instance('App\LogAcceso', $this->mock);

        $this->get($endpoint)
            ->seeJson([
                'usuario' => 'admin',
                'usuario' => 'ogarcia'
            ])
            ->assertResponseStatus(200);
    }
}
