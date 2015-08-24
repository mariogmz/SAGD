<?php

use GuzzleHttp\Client;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\AuthenticateController
 */
class AuthenticateControllerTest extends TestCase
{

    protected $endpoint = '/api/v1/authenticate';
    protected $logoutEndpoint = 'api/v1/logout';
    protected $client;

    public function setUp()
    {
        $this->client = new Client([
            'base_uri' => 'http://api.sagd.app'
        ]);
        parent::setUp();
    }

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
        $token = $this->getTokenFor('sistemas@zegucom.com.mx', 'test123');
        $response = $this->client->get($this->logoutEndpoint, [
            'query' => ['token' => $token],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $decoded_response = (array)json_decode($response->getBody()->getContents());
        $this->assertEquals(['success' => 'user logged out successfuly'], $decoded_response);
    }

    private function getTokenFor($email, $password)
    {
        $res = $this->client->post($this->endpoint, [
            'query' => ['email' => $email, 'password' => $password],
            'http_errors' => false
        ]);
        $json = $res->getBody()->getContents();
        return json_decode($json)->token;
    }
}
