<?php

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\AuthenticateController
 */
class AuthenticateControllerTest extends TestCase
{

    protected $endpoint = '/api/v1/authenticate';

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
}
