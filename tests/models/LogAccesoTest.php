<?php

use App\LogAcceso;

class LogAccesoTest extends TestCase {


    /**
     * @coversNothing
     */
    public function testLogAccesoExiste()
    {
        $la = new LogAcceso();
        $this->assertInstanceOf(LogAcceso::class, $la);
    }
}
