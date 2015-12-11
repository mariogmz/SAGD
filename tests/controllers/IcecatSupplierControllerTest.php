<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\IcecatSupplierController
 */
class IcecatSupplierControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/icecat/supplier';

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
     * @covers ::index
     */
    public function test_GET_index_ok() {
        $endpoint = $this->endpoint;

        $this->mock->shouldReceive([
            'all' => ['supplier']
        ])->withAnyArgs();
        $this->app->instance('App\IcecatSupplier', $this->mock);
        $this->get($endpoint)
            ->seeJson(['supplier'])->assertResponseStatus(200);
    }

    /**
     * @covers ::index
     */
    public function test_GET_index_name_ok() {
        $endpoint = $this->endpoint . '/name/hp';

        $this->mock->shouldReceive([
            'where' => Mockery::self(),
            'get'   => ['supplier']
        ])->withAnyArgs()->once();
        $this->app->instance('App\IcecatSupplier', $this->mock);
        $this->get($endpoint)
            ->seeJson(['supplier'])->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_ok() {
        $endpoint = $this->endpoint . '/1';

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => true,
            'self'   => 'hello'
        ])->withAnyArgs()->once();
        $this->app->instance('App\IcecatSupplier', $this->mock);

        $this->put($endpoint, ['marca_id' => 1])
            ->seeJson([
                'message'  => 'Relación actualizada correctamente',
                'supplier' => 'hello'
            ])->assertResponseStatus(200);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_failure() {
        $endpoint = $this->endpoint . '/1';

        $this->mock->shouldReceive([
            'find'   => Mockery::self(),
            'update' => false,
        ])->withAnyArgs()->once();

        $this->mock->errors = 'errors';
        $this->app->instance('App\IcecatSupplier', $this->mock);

        $this->put($endpoint, ['marca_id' => 1])
            ->seeJson([
                'message' => 'No se pudo actualizar el Fabricante',
                'error'   => 'errors'
            ])->assertResponseStatus(400);
    }

    /**
     * @covers ::update
     */
    public function test_PUT_update_not_found() {
        $endpoint = $this->endpoint . '/1';

        $this->mock->shouldReceive([
            'find'   => false
        ])->withAnyArgs()->once();

        $this->app->instance('App\IcecatSupplier', $this->mock);

        $this->put($endpoint, ['marca_id' => 1])
            ->seeJson([
                'message' => 'No se pudo actualizar el Fabricante',
                'error'   => 'El Fabricante no fué encontrado'
            ])->assertResponseStatus(404);
    }
}
