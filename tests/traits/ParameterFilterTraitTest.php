<?php

/**
 * @coversDefaultClass \App\sagd\ParameterFilter
 */
class ParameterFilterTraitTest extends TestCase {

    protected $request;

    public function setUp() {
        parent::setUp();
        $this->trait = $this->getObjectForTrait('Sagd\ParameterFilter');
        $this->request = $this->setUpMock('Illuminate\Http\Request');
    }

    public function setUpMock($class)
    {
        $mock = Mockery::mock($class);
        return $mock;
    }

    /**
     * @covers ::filter
     */
    public function testFilter()
    {
        $this->request->shouldReceive('all')
            ->withAnyArgs()
            ->andReturn(['proveedor_clave' => 'DICO']);
        $this->app->instance('Illuminate\Http\Request', $this->request);

        $model = new App\Sucursal;

        $result = $this->trait->filter($model, $this->request);

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $result);
        $this->assertGreaterThan(0, count($result));
    }
}
