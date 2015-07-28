<?php

/**
 * @coversDefaultClass \App\Cliente
 */
class ClienteTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $cliente = factory(App\Cliente::class)->make();
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEmailEsObligatorio()
    {
        $cliente = factory(App\Cliente::class)->make(['email' => null]);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEmailEsDeFormatoValido()
    {
        $cliente = factory(App\Cliente::class)->make(['email' => 'aaa']);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEmailNoEsLargo()
    {
        $cliente = factory(App\Cliente::class, 'longemail')->make();
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testEmailEsUnico()
    {
        $this->markTestIncomplete('Hacer las relaciones primero');
    }

    /**
     * @coversNothing
     */
    public function testUsuarioEsObligatorio()
    {
        $cliente = factory(App\Cliente::class)->make(['usuario' => null]);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUsuarioNoEsLargo()
    {
        $cliente = factory(App\Cliente::class, 'longusername')->make();
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPasswordEsExactamente64Caracteres()
    {
        $cliente = factory(App\Cliente::class)->make();
        $this->assertSame(64, strlen($cliente->password));
        $cliente = factory(App\Cliente::class, 'longpassword')->make();
        $this->assertFalse($cliente->isValid());
        $cliente = factory(App\Cliente::class, 'shortpassword')->make();
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio()
    {
        $cliente = factory(App\Cliente::class)->make(['nombre' => null]);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoEsLargo()
    {
        $cliente = factory(App\Cliente::class, 'longname')->make();
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaDeNacimientoNoEsObligatoria()
    {
        $cliente = factory(App\Cliente::class)->make(['fecha_nacimiento' => null]);
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaDeNacimientoEsTimestamp()
    {
        $cliente = factory(App\Cliente::class)->make(['fecha_nacimiento' => 'asd']);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSexoEsObligatorio()
    {
        $cliente = factory(App\Cliente::class)->make(['sexo' => null]);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSexoEsHombreOMujer()
    {
        $cliente = factory(App\Cliente::class)->make(['sexo' => 'aaa']);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testOcupacionNoEsObligatoria()
    {
        $cliente = factory(App\Cliente::class)->make(['ocupacion' => null]);
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testOcupacionNoPuedeSerLarga()
    {
        $cliente = factory(App\Cliente::class, 'longocc')->make();
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaVerificacionCorreoEsOpcional()
    {
        $cliente = factory(App\Cliente::class)->make(['fecha_verificacion_correo' => null]);
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaVerificacionCorreoEsTimestamp()
    {
        $cliente = factory(App\Cliente::class)->make(['fecha_verificacion_correo' => 'aaa']);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaExpiraClubZegucomEsOpcional()
    {
        $cliente = factory(App\Cliente::class)->make(['fecha_expira_club_zegucom' => null]);
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaExpiraClubZegucomEsTimestamp()
    {
        $cliente = factory(App\Cliente::class)->make(['fecha_expira_club_zegucom' => 'aaa']);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testReferenciaOtroEsOpcional()
    {
        $cliente = factory(App\Cliente::class)->make(['referencia_otro' => null]);
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testReferenciaOtroNoEsLargo()
    {
        $cliente = factory(App\Cliente::class, 'longref')->make();
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @covers ::estatus
     */
    public function testEstatus()
    {
        $estatus = factory(App\ClienteEstatus::class)->create();
        $cliente = factory(App\Cliente::class)->make();
        $cliente->estatus()->associate($estatus);
        $this->assertInstanceOf(App\ClienteEstatus::class, $cliente->estatus);
    }

    /**
     * @covers ::referencia
     */
    public function testReferencia()
    {
        $referencia = factory(App\ClienteReferencia::class)->create();
        $cliente = factory(App\Cliente::class)->make();
        $cliente->referencia()->associate($referencia);
        $this->assertInstanceOf(App\ClienteReferencia::class, $cliente->referencia);
    }

    /**
     * @covers ::comentarios
     */
    public function testComentarios()
    {
        $cliente = factory(App\Cliente::class)->make();
        $empleado = factory(App\Empleado::class)->create();
        $this->markTestIncomplete('Guess what? We cant save a Cliente');
    }

    /**
     * @covers ::autorizaciones
     */
    public function testAutorizaciones()
    {
        $this->markTestIncomplete("Arggghhh");
    }

    /**
     * @covers ::empleado
     */
    public function testEmpleado()
    {
        $cliente = factory(App\Cliente::class)->make();
        $empleado = factory(App\Empleado::class)->create();
        $cliente->empleado()->associate($empleado);
        $this->assertInstanceOf(App\Empleado::class, $cliente->empleado);
    }

    /**
     * @covers ::vendedor
     */
    public function testVendedor()
    {
        $cliente = factory(App\Cliente::class)->make();
        $empleado = factory(App\Empleado::class)->create();
        $cliente->vendedor()->associate($empleado);
        $this->assertInstanceOf(App\Empleado::class, $cliente->vendedor);
    }

    /**
     * @covers ::sucursal
     */
    public function testSucursal()
    {
        $cliente = factory(App\Cliente::class)->make();
        $sucursal = factory(App\Sucursal::class)->create();
        $cliente->sucursal()->associate($sucursal);
        $this->assertInstanceOf(App\Sucursal::class, $cliente->sucursal);
    }
}
