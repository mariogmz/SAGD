<?php

use GuzzleHttp\Client;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\AuthenticateController
 */
class EmpleadoControllerTest extends TestCase
{

    protected $endpoint = '/api/v1/empleado';
    protected $authEndpoint = '/api/v1/authenticate';
    protected $client;

    public function setUp()
    {
        $this->client = new Client([
            'base_uri' => 'http://api.sagd.app'
        ]);
        parent::setUp();
    }

    /**
     * @covers ::index
     */
    public function test_GET_empleado_with_no_token()
    {
        $response = $this->client->get($this->endpoint, ['http_errors' => false]);

        $this->assertEquals(400, $response->getStatusCode());
        $response = (array)json_decode($response->getBody()->getContents());
        $this->assertEquals(['error' => 'token_not_provided'], $response);
    }

    /**
     * @covers ::index
     */
    public function test_POST_to_index()
    {
        $response = $this->client->post($this->endpoint, [
            'query' => [],
            'http_errors' => false
        ]);

        $this->assertEquals(405, $response->getStatusCode());
        $response = (array)json_decode($response->getBody()->getContents());
        $this->assertEquals(['error' => 'method_not_allowed'], $response);
    }

    /**
     * @covers ::index
     */
    public function test_GET_with_invalid_token()
    {
        $response = $this->client->get($this->endpoint, [
            'query' => ['token' => 'allahu.akbar.boom'],
            'http_errors' => false
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        $response = (array)json_decode($response->getBody()->getContents());
        $this->assertEquals(['error' => 'token_invalid'], $response);
    }

    /**
     * @covers ::index
     */
    public function test_GET_with_valid_token()
    {
        $token = $this->getTokenFor('sistemas@zegucom.com.mx', 'test123');
        $response = $this->client->get($this->endpoint, [
            'query' => ['token' => $token],
            'http_errors' => false
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    private function getTokenFor($email, $password)
    {
        $res = $this->client->post($this->authEndpoint, [
            'query' => ['email' => $email, 'password' => $password],
            'http_errors' => false
        ]);
        $json = json_decode( $res->getBody()->getContents() );
        $json = (array)$json;
        return $json['token'];
    }
}
