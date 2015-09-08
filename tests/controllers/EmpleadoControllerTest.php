<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\EmpleadoController
 */
class EmpleadoControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/empleado';

    public function __construct()
    {
        $this->mock = Mockery::mock('Empleado');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @covers ::index
     */
    public function test_POST_index()
    {
        $response = $this->call('POST', $this->endpoint);
        $content = json_decode($response->getContent());

        $this->assertEquals(405, $response->status());
        $this->assertEquals('method_not_allowed', $content->error);
    }

    /**
     * @covers ::index
     */
    public function test_GET_index()
    {
        $this->mock
            ->shouldReceive('all')
            ->once()
            ->andReturn('{empleados: {}}');
        $this->app->instance('Empleado', $this->mock);

        $response = $this->call('GET', $this->endpoint);

        $this->assertEquals(200, $response->status());
    }
}
