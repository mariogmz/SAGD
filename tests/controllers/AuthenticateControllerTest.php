<?php

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\AuthenticateController
 */
class AuthenticateControllerTest extends TestCase
{

    protected $endpoint = '/api/v1/authenticate';
    protected $logoutEndpoint = 'api/v1/logout';

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
        $response = $this->call('POST', $this->endpoint, [
            'email' => 'sistemas@zegucom.com.mx', 'password' => 'test123']);

        $this->assertEquals(200, $response->status());
    }

    /**
     * @covers ::authenticate
     */
    public function test_user_gets_last_login_timestamp_saved()
    {
        $response = $this->call('POST', $this->endpoint, [
            'email' => 'sistemas@zegucom.com.mx', 'password' => 'test123']);
        $user = App\User::where('email', 'sistemas@zegucom.com.mx')->first();
        $empleado = $user->morphable;
        $expected = substr(\Carbon\Carbon::now('America/Mexico_City')->toDateTimeString(), 0, 10);
        $regexp = sprintf("/%s.*/", $expected);
        $this->assertNotNull($empleado->fecha_ultimo_ingreso);
        $this->assertRegExp($regexp, $empleado->fecha_ultimo_ingreso);
    }

    /**
     * @covers ::logout
     */
    public function test_successful_logout()
    {
        $token = $this->authenticate('sistemas@zegucom.com.mx', 'test123');
        $response = $this->call('GET', $this->logoutEndpoint, [
            'token' => $token
        ]);

        $this->assertEquals(200, $response->status());
        $decoded_response = $response->content();
        $this->assertEquals(json_encode(['success' => 'user logged out successfuly']), $decoded_response);
    }

    /**
     * @covers ::getAuthenticatedEmpleado
     */
    public function test_GET_to_empleado_returns_a_valid_empleado()
    {
        // Loguearse
        $token = $this->authenticate('sistemas@zegucom.com.mx', 'test123');
        // Llamar a endpoint de esta prueba
        $response = $this->call('GET', $this->endpoint . '/empleado',[
            'token' => $token
        ]);
        $empleado_json = $response->content();
        $empleado_db = json_encode(['empleado' => App\Empleado::where('usuario','admin')->first()]);
        $this->assertEquals($empleado_db, $empleado_json);
    }

    private function authenticate($email, $password)
    {
        $response = $this->call('POST', $this->endpoint, [
            'email' => $email,
            'password' => $password
        ]);
        return json_decode($response->content())->token;
    }
}
