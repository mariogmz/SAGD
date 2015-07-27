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

    /**
     * @coversNothing
     */
    public function testLogAccesoTieneTablaLog_Acceso()
    {
        $la = new LogAcceso();
        $this->assertAttributeEquals('log_acceso', 'table', $la);
    }
}
