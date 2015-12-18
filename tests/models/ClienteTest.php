<?php

/**
 * @coversDefaultClass \App\Cliente
 */
class ClienteTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testModeloEsValido() {
        $cliente = factory(App\Cliente::class)->make();
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $cliente->nombre = 'Anthony Hoskins';
        $this->assertTrue($cliente->isValid('update'));
        $this->assertTrue($cliente->save());
        $this->assertSame('Anthony Hoskins', $cliente->nombre);
    }

    /**
     * @coversNothing
     */
    public function testUsuarioEsObligatorio() {
        $cliente = factory(App\Cliente::class)->make(['usuario' => null]);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testUsuarioEsUnico() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $cliente_test = factory(App\Cliente::class, 'full')->make();
        $usuario = $cliente_test->usuario;
        $cliente_test->usuario = $cliente->usuario;
        $this->assertFalse($cliente_test->isValid());
        $cliente_test->usuario = $usuario;
        $this->assertTrue($cliente_test->isValid());
    }


    /**
     * @coversNothing
     */
    public function testUsuarioNoEsLargo() {
        $cliente = factory(App\Cliente::class, 'longusername')->make();
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreEsObligatorio() {
        $cliente = factory(App\Cliente::class)->make(['nombre' => null]);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoEsLargo() {
        $cliente = factory(App\Cliente::class, 'longname')->make();
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaDeNacimientoNoEsObligatoria() {
        $cliente = factory(App\Cliente::class)->make(['fecha_nacimiento' => null]);
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaDeNacimientoEsTimestamp() {
        $cliente = factory(App\Cliente::class)->make(['fecha_nacimiento' => 'asd']);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSexoEsObligatorio() {
        $cliente = factory(App\Cliente::class)->make(['sexo' => null]);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSexoEsHombreOMujer() {
        $cliente = factory(App\Cliente::class)->make(['sexo' => 'aaa']);
        $this->assertFalse($cliente->isValid());
        $cliente->sexo = 'HOMBRE';
        $this->assertTrue($cliente->isValid());
        $cliente->sexo = 'MUJER';
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testOcupacionNoEsObligatoria() {
        $cliente = factory(App\Cliente::class)->make(['ocupacion' => null]);
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testOcupacionNoPuedeSerLarga() {
        $cliente = factory(App\Cliente::class, 'longocc')->make();
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaVerificacionCorreoEsOpcional() {
        $cliente = factory(App\Cliente::class)->make(['fecha_verificacion_correo' => null]);
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaVerificacionCorreoEsTimestamp() {
        $cliente = factory(App\Cliente::class)->make(['fecha_verificacion_correo' => 'aaa']);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaExpiraClubZegucomEsOpcional() {
        $cliente = factory(App\Cliente::class)->make(['fecha_expira_club_zegucom' => null]);
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testFechaExpiraClubZegucomEsTimestamp() {
        $cliente = factory(App\Cliente::class)->make(['fecha_expira_club_zegucom' => 'aaa']);
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testReferenciaOtroEsOpcional() {
        $cliente = factory(App\Cliente::class)->make(['referencia_otro' => null]);
        $this->assertTrue($cliente->isValid());
    }

    /**
     * @coversNothing
     */
    public function testReferenciaOtroNoEsLargo() {
        $cliente = factory(App\Cliente::class, 'longref')->make();
        $this->assertFalse($cliente->isValid());
    }

    /**
     * @covers ::estatus
     * @group relaciones
     */
    public function testEstatus() {
        $estatus = factory(App\ClienteEstatus::class)->create();
        $cliente = factory(App\Cliente::class)->make();
        $cliente->estatus()->associate($estatus);
        $this->assertInstanceOf(App\ClienteEstatus::class, $cliente->estatus);
    }

    /**
     * @covers ::referencia
     * @group relaciones
     */
    public function testReferencia() {
        $referencia = factory(App\ClienteReferencia::class)->create();
        $cliente = factory(App\Cliente::class)->make();
        $cliente->referencia()->associate($referencia);
        $this->assertInstanceOf(App\ClienteReferencia::class, $cliente->referencia);
    }

    /**
     * @covers ::comentarios
     * @group relaciones
     */
    public function testComentarios() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $empleado = factory(App\Empleado::class)->create();
        $cliente->empleados()->attach($empleado, ['comentario' => "Balalalala"]);
        $comentarios = $cliente->comentarios;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $comentarios);
        $this->assertInstanceOf(App\ClienteComentario::class, $comentarios[0]);
    }

    /**
     * @covers ::autorizaciones
     * @group relaciones
     */
    public function testAutorizaciones() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $autorizado = factory(App\Cliente::class, 'full')->create();

        factory(App\ClienteAutorizacion::class)->create([
            'cliente_id'            => $cliente->id,
            'cliente_autorizado_id' => $autorizado->id,
            'nombre_autorizado'     => null
        ]);
        $autorizaciones = $cliente->autorizaciones;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $autorizaciones);
        $this->assertInstanceOf(App\ClienteAutorizacion::class, $autorizaciones[0]);
    }

    /**
     * @covers ::empleado
     * @group relaciones
     */
    public function testEmpleado() {
        $cliente = factory(App\Cliente::class)->make();
        $empleado = factory(App\Empleado::class)->create();
        $cliente->empleado()->associate($empleado);
        $this->assertInstanceOf(App\Empleado::class, $cliente->empleado);
    }

    /**
     * @covers ::vendedor
     * @group relaciones
     */
    public function testVendedor() {
        $cliente = factory(App\Cliente::class)->make();
        $empleado = factory(App\Empleado::class)->create();
        $cliente->vendedor()->associate($empleado);
        $this->assertInstanceOf(App\Empleado::class, $cliente->vendedor);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal() {
        $cliente = factory(App\Cliente::class)->make();
        $sucursal = factory(App\Sucursal::class)->create();
        $cliente->sucursal()->associate($sucursal);
        $this->assertInstanceOf(App\Sucursal::class, $cliente->sucursal);
    }

    /**
     * @covers ::paginasWebDistribuidores
     * @group relaciones
     */
    public function testPaginasWebDistribuidores() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $pwd = factory(App\PaginaWebDistribuidor::class)->make();
        $cliente->paginasWebDistribuidores()->save($pwd);
        $pwds = $cliente->paginasWebDistribuidores;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $pwds);
        $this->assertInstanceOf(App\PaginaWebDistribuidor::class, $pwds[0]);
    }

    /**
     * @covers ::domicilios
     * @group relaciones
     */
    public function testDomicilios() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $domicilio = factory(App\Domicilio::class)->create();
        $cliente->domicilios()->attach($domicilio);
        $domicilios = $cliente->domicilios;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $domicilios);
        $this->assertInstanceOf(App\Domicilio::class, $domicilios[0]);
    }

    /**
     * @covers ::serviciosSoportes
     * @group relaciones
     */
    public function testServiciosSoportes() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $servicios_soportes = factory(App\ServicioSoporte::class, 5)->create([
            'cliente_id' => $cliente->id
        ]);
        $servicios_soportes_resultado = $cliente->serviciosSoportes;
        for ($i = 0; $i < 5; $i ++) {
            $this->assertEquals($servicios_soportes[$i]->id, $servicios_soportes_resultado[$i]->id);
        }
    }

    /**
     * @covers ::rmas
     * @group relaciones
     */
    public function testRmas() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        factory(App\Rma::class, 5)->create([
            'cliente_id' => $cliente->id
        ]);
        $rmas_resultado = $cliente->rmas;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $rmas_resultado);
        $this->assertInstanceOf(App\Rma::class, $rmas_resultado[0]);
    }

    /**
     * @covers ::razonesSociales
     * @group relaciones
     */
    public function testRazonesSociales() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        factory(App\RazonSocialReceptor::class, 'full')->create([
            'cliente_id' => $cliente->id]);
        $rsrs = $cliente->razonesSociales;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $rsrs);
        $this->assertInstanceOf(App\RazonSocialReceptor::class, $rsrs[0]);
        $this->assertCount(1, $rsrs);
    }

    /**
     * @covers ::user
     * @group relaciones
     */
    public function testUser() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        factory(App\User::class)->create([
            'morphable_id'   => $cliente->id,
            'morphable_type' => get_class($cliente)
        ]);
        $this->assertInstanceOf(App\User::class, $cliente->user);
    }

    /**
     * @covers ::tabuladores
     * @group relaciones
     */
    public function testTabuladores(){
        $this->markTestIncomplete('Not implemented yet.');
    }
}
