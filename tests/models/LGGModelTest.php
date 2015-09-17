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
     * @covers ::destroy
     */
    public function test_destroy()
    {
        $this->markTestIncomplete('Not yet implemented');
    }
}
