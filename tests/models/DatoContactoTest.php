<?php

use App\DatoContacto;

class DatoContactoTest extends TestCase {


    public function testDatoContactoExiste()
    {
        $dc = new DatoContacto();
        $this->assertInstanceOf(DatoContacto::class, $dc);
    }

    public function testModeloDatoContactoTieneAsociadoTablaDatos_contactos(){
        $dc = new DatoContacto();
        $this->assertAttributeEquals('datos_contacto','table',$dc);
    }

    public function testNumeroDeTelefonoValido(){
        $dato_contacto = factory(DatoContacto::class)->make([
            'telefono' => '12345678' // Menos de 11 caracteres
        ]);
        $this->assertFalse($dato_contacto->isValid());
        $dato_contacto->telefono = '1234567890a'; // 11 caracteres pero contiene una letra
        $this->assertFalse($dato_contacto->isValid());
    }

    public function testEmailTieneFormatoValido(){
        $dato_contacto = factory(DatoContacto::class)->make([
            'email' => 'prueba_1.2@@email.com@'
        ]);
        $this->assertFalse($dato_contacto->isValid());
    }

    public function testDatoTieneAsociadoUnEmpleado(){
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testUrlTieneFormatoValido(){
        $dato_contacto = factory(DatoContacto::class)->make([
            'fotografia_url' => 'http:://google.com.mx'
        ]);
        $this->assertFalse($dato_contacto->isValid());
    }

}
