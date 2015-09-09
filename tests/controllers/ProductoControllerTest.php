<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\ProductoController
 */
class ProductoControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/producto';

    public function __construct()
    {
        $this->mock = Mockery::mock('App\Producto');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @covers ::index
     */
    public function test_GET_index()
    {
        $this->mock
            ->shouldReceive('all')
            ->andReturn('{productos: {}}');

        $this->app->instance('App\Producto', $this->mock);

        $response = $this->call('GET', $this->endpoint);

        $this->assertEquals(200, $response->status());
    }
}
