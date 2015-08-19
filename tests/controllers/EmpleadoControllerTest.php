<?php

use GuzzleHttp\Client;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\AuthenticateController
 */
class EmpleadoControllerTest extends TestCase
{

    protected $endpoint = '/api/v1/empleado';
    protected $client;

    public function setUp()
    {
        $this->client = new Client([
            'base_uri' => 'http://sagd.app'
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
        $this->assertEquals(['error' => 'token_not_provided'], $response->json());
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

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals(['error' => 'method_not_allowed'], $response->json());
    }

    /**
     * @covers ::index
     */
    public function test_GET_with_invalid_token()
    {
        $response = $this->client->get($this->endpoint, [
            'query' => ['token' => 'allahu akbar'],
            'http_errors' => false
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(['error' => 'token_invalid'], $response->json());
    }

    /**
     * @covers ::index
     */
    public function test_GET_with_valid_token()
    {
        $token = $this->getTokenFor('sistemas@zegucom.com.mx', 'test123');
        $response = $this->client->get($this->endpoint, [
            'query' => $token,
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    private function getTokenFor($email, $password)
    {
        $json = $this->client->post($this->endpoint, [
            'query' => ['email' => $email, 'password' => $password],
            'http_errors' => false
        ])->json();
        return json_decode($json);
    }
}
