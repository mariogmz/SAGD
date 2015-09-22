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
}
