<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\IcecatSupplierController
 */
class IcecatSupplierControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/icecat/supplier/{name}';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\IcecatSupplier');
    }

    public function setUpMock($class) {
        $mock = Mockery::mock($class);

        return $mock;
    }

    public function tearDown() {
        Mockery::close();
    }

    /**
     * @covers ::obtenerFicha
     */
    public function test_GET_index_ok() {
        $endpoint = str_replace('{name}', '', $this->endpoint);

        $this->mock->shouldReceive([
            'all' => ['supplier']
        ])->withAnyArgs();
        $this->app->instance('App\IcecatSupplier', $this->mock);
        $this->get($endpoint)
            ->seeJson(['supplier'])->assertResponseStatus(200);
    }

    /**
     * @covers ::obtenerFicha
     */
    public function test_GET_index_name_ok() {
        $endpoint = str_replace('{name}', 'hp', $this->endpoint);

        $this->mock->shouldReceive([
            'whereName' => Mockery::self(),
            'all'       => ['supplier']
        ])->withAnyArgs()->once();
        $this->app->instance('App\IcecatSupplier', $this->mock);
        $this->get($endpoint)
            ->seeJson(['supplier'])->assertResponseStatus(200);
    }

}
