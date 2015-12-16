<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\IcecatController
 */
class IcecatControllerTest extends TestCase {

    use WithoutMiddleware;

    protected $endpoint = '/v1/icecat/{numero_parte}/marca/{marca}';

    public function setUp() {
        parent::setUp();
        $this->mock = $this->setUpMock('Sagd\IcecatFeed');
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
    public function test_GET_obtener_ficha_ok() {
        $endpoint = str_replace('{numero_parte}', 'CB049A', $this->endpoint);
        $endpoint = str_replace('{marca}', '1', $endpoint);

        $this->mock->shouldReceive([
            'getProductSheetRaw' => 'sheet_data'
        ])->withAnyArgs();
        $this->app->instance('Sagd\IcecatFeed', $this->mock);
        $this->get($endpoint)
            ->seeJson([
                'message' => 'Se recuperó la ficha desde Icecat correctamente.',
                'ficha'   => 'sheet_data'
            ])->assertResponseStatus(200);
    }

    /**
     * @covers ::obtenerFicha
     */
    public function test_GET_obtener_ficha_no_encontrada() {
        $endpoint = str_replace('{numero_parte}', 'CB049A', $this->endpoint);
        $endpoint = str_replace('{marca}', '1', $endpoint);

        $this->mock->shouldReceive([
            'getProductSheetRaw' => 'sheet_data'
        ])->withAnyArgs()->once();
        $this->app->instance('Sagd\IcecatFeed', $this->mock);
        $this->get($endpoint)
            ->seeJson([
                'message' => 'Se recuperó la ficha desde Icecat correctamente.',
                'ficha'   => 'sheet_data'
            ])->assertResponseStatus(200);
    }


}
