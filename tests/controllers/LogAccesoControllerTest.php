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
}
