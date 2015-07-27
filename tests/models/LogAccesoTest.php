<?php

use App\LogAcceso;

class LogAccesoTest extends TestCase {


    public function testLogAccesoExiste()
    {
        $la = new LogAcceso();
        $this->assertInstanceOf(LogAcceso::class, $la);
    }

    public function testLogAccesoTieneTablaLog_Acceso()
    {
        $la = new LogAcceso();
        $this->assertAttributeEquals('log_acceso', 'table', $la);
    }
}
