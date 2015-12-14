<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\IcecatFeatureController
 */
class IcecatFeatureControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/icecat/feature';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('App\IcecatFeature');
    }

    public function setUpMock($class) {
        $mock = Mockery::mock($class);

        return $mock;
    }

    public function tearDown() {
        Mockery::close();
    }

    /**
     * @covers ::index
     */
    public function test_GET_index_ok() {
        $endpoint = $this->endpoint;

        $this->mock->shouldReceive([
            'all' => ['feature']
        ])->withAnyArgs();
        $this->app->instance('App\IcecatFeature', $this->mock);
        $this->get($endpoint)
            ->seeJson(['feature'])->assertResponseStatus(200);
    }

    /**
     * @covers ::index
     */
    public function test_GET_index_name_ok() {
        $endpoint = $this->endpoint . '/name/hp';

        $this->mock->shouldReceive([
            'where' => Mockery::self(),
            'get'   => ['feature']
        ])->withAnyArgs()->once();
        $this->app->instance('App\IcecatFeature', $this->mock);
        $this->get($endpoint)
            ->seeJson(['feature'])->assertResponseStatus(200);
    }
}
