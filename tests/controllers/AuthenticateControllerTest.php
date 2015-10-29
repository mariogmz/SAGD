<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;


/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\AuthenticateController
 */
class AuthenticateControllerTest extends TestCase
{

    protected $endpoint = '/v1/authenticate';
    protected $logoutEndpoint = '/v1/logout';

    /**
     * @covers ::authenticate
     */
    public function test_GET()
    {
        $this->get($this->endpoint)
            ->seeJsonEquals([
                'error' => 'method_not_allowed'
            ]);
    }

    /**
     * @covers ::authenticate
     */
    public function test_POST_with_no_parameters()
    {
        JWTAuth::shouldReceive('attempt')
            ->withAnyArgs()
            ->andReturn(null);

        $this->post($this->endpoint, [])
            ->seeJsonEquals([
                'error' => 'invalid_credentials'
            ]);
    }

    /**
     * @covers ::authenticate
     */
    public function test_POST_with_invalid_credentials()
    {
        JWTAuth::shouldReceive('attempt')
            ->withAnyArgs()
            ->andReturn(null);

        $this->post($this->endpoint, ['email' => 'a@gmail.com', 'password' => 'hello'])
            ->seeJsonEquals([
                'error' => 'invalid_credentials'
            ]);
    }

    /**
     * @covers ::authenticate
     */
    public function test_POST_with_valid_credentials()
    {
        JWTAuth::shouldReceive([
            'attempt' => 'abcd',
            'toUser' => App\User::first()
            ])
            ->withAnyArgs();

        $this->post($this->endpoint, ['email' => 'sistemas@zegucom.com.mx', 'password' => 'admin2015'])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::authenticate
     * @group last-login
     */
    public function test_user_gets_last_login_timestamp_saved()
    {
        $expectedDate = \Carbon\Carbon::now('America/Mexico_City')->toDateTimeString();
        $this->post($this->endpoint, ['email' => 'sistemas@zegucom.com.mx', 'password' => 'admin2015'])
            ->assertResponseStatus(200);
        $user = App\User::where('email', 'sistemas@zegucom.com.mx')->first();
        $empleado = $user->morphable;
        $this->assertNotNull($empleado->fecha_ultimo_ingreso);
        $this->assertEquals($expectedDate, $empleado->fecha_ultimo_ingreso);
    }

    /**
     * @covers ::logout
     */
    public function test_successful_logout()
    {
        $this->withoutMiddleware();

        JWTAuth::shouldReceive([
            'parseToken->authenticate' => true
            ])->withAnyArgs();

        JWTAuth::shouldReceive('invalidate')->once()->withNoArgs();

        $response = $this->get($this->logoutEndpoint, ['token' => 'abcd'])
            ->seeJson([
                'success' => 'user logged out successfuly'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::getAuthenticatedEmpleado
     * @covers ::getUser
     * @covers ::getEmpleado
     * @group get-empleado
     */
    public function test_GET_to_empleado_returns_a_valid_empleado()
    {
        $this->withoutMiddleware();

        JWTAuth::shouldReceive([
            'parseToken->authenticate' => App\User::where('email', 'sistemas@zegucom.com.mx')->first()
            ])
            ->withAnyArgs();

        $endpoint = $this->endpoint . '/empleado';

        $this->get($endpoint, ['token' => 'abcd'])
            ->seeJson([
                'usuario' => 'admin',
                'email' => 'sistemas@zegucom.com.mx'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::getAuthenticatedEmpleado
     * @covers ::getUser
     * @covers ::getEmpleado
     * @group get-empleado
     */
    public function test_GET_empleado_returns_with_sucursal()
    {
        $this->withoutMiddleware();

        JWTAuth::shouldReceive([
            'parseToken->authenticate' => App\User::first()
        ])
        ->withAnyArgs();

        $endpoint = $this->endpoint . '/empleado';

        $this->get($endpoint, ['token' => 'abcd'])
            ->seeJson([
                'usuario' => 'admin',
                'clave' => 'DICOTAGS'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::authenticate
     * @covers ::intentoDeLogin
     * @covers ::setLastLoginToEmployee
     * @covers ::getEmpleado
     * @covers ::attemptLogin
     * @covers ::attemptLoginWithUsuario
     * @group username-login
     */
    public function testIniciarSesionConUsuarioYPassword()
    {
        $this->post($this->endpoint, ['email' => 'ogarcia', 'password' => 'ogarcia2015'])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::authenticate
     * @covers ::intentoDeLogin
     * @covers ::setLastLoginToEmployee
     * @covers ::getEmpleado
     * @covers ::attemptLogin
     * @covers ::attemptLoginWithUsuario
     * @group username-login
     */
    public function testIniciarSesionConUsuarioCorrectoYPasswordIncorrecto()
    {
        $this->post($this->endpoint, ['email' => 'ogarcia', 'password' => 'ogarcia'])
            ->assertResponseStatus(401);
    }
}
