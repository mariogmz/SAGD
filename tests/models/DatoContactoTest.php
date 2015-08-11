<?php

/**
 * @coversDefaultClass \App\DatoContacto
 */
class DatoContactoTest extends TestCase {


    /**
     * @coversNothing
     */
    public function testDatoContactoExiste()
    {
        $dc = new App\DatoContacto();
        $this->assertInstanceOf(App\DatoContacto::class, $dc);
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $dc = factory(App\DatoContacto::class)->create();
        $dc->skype = 'SKYPE';
        $this->assertTrue($dc->isValid('update'));
        $this->assertTrue($dc->save());
    }

    /**
     * @coversNothing
     */
    public function testEmailTieneFormatoValido()
    {
        $dato_contacto = factory(App\DatoContacto::class)->create([
            'email' => 'prueba_1.2@@email.com@'
        ]);
        $this->assertFalse($dato_contacto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUrlTieneFormatoValido()
    {
        $dato_contacto = factory(App\DatoContacto::class)->create([
            'fotografia_url' => 'http:://google.com.mx'
        ]);
        $this->assertFalse($dato_contacto->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDatoContactoValido(){
        $dato_contacto = factory(App\DatoContacto::class)->make();
        $this->assertTrue($dato_contacto->isValid());
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado()
    {
        $empleado = factory(App\Empleado::class)->create();
        $dato_contacto = factory(App\DatoContacto::class)->create([
            'empleado_id' => $empleado->id
        ]);
        $empleado_test = $dato_contacto->empleado;
        $this->assertInstanceOf(App\Empleado::class, $empleado_test);
    }

}
