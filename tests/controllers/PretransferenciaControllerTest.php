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
        $this->mock = $this->setUpMock('App\Pretransferencia');
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
            'with->selectRaw->join->where->groupBy->get' => []
        ])->withAnyArgs();
        $this->app->instance('App\Pretransferencia', $this->mock);

        $this->get($endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::imprimir
     * @group feature-transferencias
     */
    public function testGetImprimir()
    {
        $endpoint = $this->endpoint . '/pretransferencias/imprimir/origen/1/destino/2';

        $this->mock->shouldReceive([
            'pdf' => []
        ])->withAnyArgs();
        $this->app->instance('App\Pretransferencia', $this->mock);

        $this->get($endpoint)
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testPostTransferir()
    {
        $endpoint = $this->endpoint . '/pretransferencias/transferir/origen/1/destino/2';

        $this->mock->shouldReceive([
            'transferir' => true
        ])->withAnyArgs();
        $this->app->instance('App\Pretransferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Pretransferencias marcadas como transferidas'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::transferir
     * @group feature-transferencias
     */
    public function testPostTransferirFail()
    {
        $endpoint = $this->endpoint . '/pretransferencias/transferir/origen/1/destino/2';

        $this->mock->shouldReceive([
            'transferir' => false
        ])->withAnyArgs();
        $this->app->instance('App\Pretransferencia', $this->mock);

        $this->post($endpoint)
            ->seeJson([
                'message' => 'Pretranferencias no marcadas como transferidas'
            ])
            ->assertResponseStatus(400);
    }
}
