<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\PretransferenciaController
 */
class PretransferenciaControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/inventario';

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->setUpMock('App\Sucursal');
    }

    public function setUpMock($class)
    {
        $mock = Mockery::mock($class);
        return $mock;
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
        $endpoint = $this->endpoint . '/pretransferencias/origen/1';

        $this->mock->shouldReceive([
            'selectRaw->join->join->where->where->groupBy->get' => []
        ])->withAnyArgs();
        $this->app->instance('App\Sucursal', $this->mock);

        $this->get($endpoint)
            ->assertResponseStatus(200);
    }
}
