<?php

use App\LGGModel;

/**
 * @coversDefaultClass \App\LGGModel
 */
class LGGModelTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->setUpMock('App\LGGModel');
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
     * @coversNothing
     * Testing on an actual model since LGGModel can't be instantiated nor mocked
     */
    public function testSoftDeletes()
    {
        $model = App\Margen::create([
            'nombre' => 'Margen',
            'valor' => 0.1,
            'valor_webservice_p1' => 0.1,
            'valor_webservice_p8' => 0.2
        ]);

        $this->assertNull($model->deleted_at);
        $this->assertFalse($model->trashed());

        $model->delete();
        $this->assertInstanceOf(Carbon\Carbon::class, $model->deleted_at);
        $this->assertNotNull($model->deleted_at);
        $this->assertTrue($model->trashed());

        $model->restore();
        $this->assertNull($model->deleted_at);
        $this->assertFalse($model->trashed());
    }

    /**
     * @covers ::bulkUpdate
     * @covers ::checkCorrectArrayForBulkUpdate
     * @covers ::preparevaluesForBulkInsert
     * @covers ::performBulkUpdateWith
     * @group feature/bulk-updates
     */
    public function testBulkUpdateDeUnaMarca()
    {
        factory(App\Marca::class, 5)->create();
        $marca = new App\Marca;
        $time = "Z".time();
        $lastId = App\Marca::last()->id;

        $ret_value = $marca->bulkUpdate('nombre', 'id', [
            $lastId => $time,
            $lastId-1 => 'Computo',
            $lastId-2 => 'Woot'
        ]);

        $this->assertGreaterThan(0, $ret_value);
        $this->assertEquals($time, App\Marca::find($lastId)->nombre);
        $this->assertEquals('Computo', App\Marca::find($lastId-1)->nombre);
        $this->assertEquals('Woot', App\Marca::find($lastId-2)->nombre);
    }

    /**
     * @covers ::bulkUpdate
     * @covers ::checkCorrectArrayForBulkUpdate
     * @group feature/bulk-updates
     */
    public function testBulkUpdateArrayVacioRegresaNegativo()
    {
        $marca = new App\Marca;

        $badArray = [];

        $this->assertFalse($marca->bulkUpdate('nombre', 'id', $badArray));
    }
}
