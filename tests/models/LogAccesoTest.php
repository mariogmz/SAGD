<?php

use App\LogAcceso;

class DatoContactoTest extends TestCase {


    public function testDatoContactoExiste()
    {
        $la = new LogAcceso();
        $this->assertInstanceOf(DatoContacto::class, $la);
    }

    public function testModeloDatoContactoTieneAsociadoTablaDatos_contactos(){
        $la = new LogAcceso();
        $this->assertAttributeEquals('log_acceso','table',$la);
    }

    public function test


}
