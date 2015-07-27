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

    public function testFechaEsValida()
    {
        $log_entry = factory(LogAcceso::class)->make();
        $this->assertTrue($log_entry->isValid());
    }
}
