<?php

use App\Domicilio;

/**
 * @coversDefaultClass \App\Domicilio
 */
class DomicilioTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testDomicilioEsValido() {
        $domicilio = factory(Domicilio::class)->make();
        $this->assertTrue($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCalleEsRequerida() {
        $domicilio = factory(Domicilio::class)->make([
            'calle' => ''
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testLocalidadEsRequerida() {
        $domicilio = factory(Domicilio::class)->make([
            'localidad' => ''
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalAsociadoEsRequerido() {
        $domicilio = factory(Domicilio::class)->make([
            'codigo_postal_id' => null
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $model = factory(App\Domicilio::class)->create();
        $model->calle = "Boulevard of Broken Dreams";
        $this->assertTrue($model->isValid('update'));
        $this->assertTrue($model->save());
    }

    /**
     * @covers ::codigoPostal
     * @group relaciones
     */
    public function testCodigoPostal() {
        $codigo_postal = factory(App\CodigoPostal::class)->create();
        $domicilio = factory(App\Domicilio::class)->create([
            'codigo_postal_id' => $codigo_postal->id
        ]);
        $codigo_postal_resultado = $domicilio->codigoPostal;
        $this->assertInstanceOf(App\CodigoPostal::class, $codigo_postal_resultado);
    }

    /**
     * @covers ::telefonos
     * @group relaciones
     */
    public function testTelefonos() {
        $parent = factory(App\Domicilio::class)->create();
        factory(App\Telefono::class)->create([
            'domicilio_id' => $parent->id
        ]);
        $children = $parent->telefonos;
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $children);
        $this->assertInstanceOf('App\Telefono', $children[0]);
        $this->assertCount(1, $children);
    }

    /**
     * @covers ::sucursales
     * @group relaciones
     */
    public function testSucursales() {
        $domicilio = factory(App\Domicilio::class)->create();
        $sucursales = factory(App\Sucursal::class, 5)->create([
            'domicilio_id' => $domicilio->id
        ]);
        $sucursales_resultado = $domicilio->sucursales;
        for ($i = 0; $i < 5; $i ++) {
            $this->assertInstanceOf(App\Sucursal::class, $sucursales[$i]);
        }
    }

    /**
     * @covers ::clientes
     * @group relaciones
     */
    public function testClientes() {
        $cliente = factory(App\Cliente::class, 'full')->create();
        $domicilio = factory(App\Domicilio::class)->create();
        $domicilio->clientes()->attach($cliente);
        $clientes = $domicilio->clientes;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $clientes);
        $this->assertInstanceOf(App\Cliente::class, $clientes[0]);
    }

    /**
     * @covers ::razonesSocialesEmisores
     * @group relaciones
     */
    public function testRazonesSocialesEmisores() {
        $domicilio = factory(App\Domicilio::class)->create();
        factory(App\RazonSocialEmisor::class, 'full')->create([
            'domicilio_id' => $domicilio->id]);
        $rses = $domicilio->razonesSocialesEmisores;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $rses);
        $this->assertInstanceOf(App\RazonSocialEmisor::class, $rses[0]);
        $this->assertCount(1, $rses);
    }

    /**
     * @covers ::razonesSocialesReceptores
     * @group relaciones
     */
    public function testRazonesSocialesReceptores() {
        $domicilio = factory(App\Domicilio::class)->create();
        factory(App\RazonSocialReceptor::class, 'full')->create([
            'domicilio_id' => $domicilio->id]);
        $rsrs = $domicilio->razonesSocialesReceptores;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $rsrs);
        $this->assertInstanceOf(App\RazonSocialReceptor::class, $rsrs[0]);
        $this->assertCount(1, $rsrs);
    }

    /**
     * @covers ::guardarTelefonos
     * @covers ::crearNuevosTelefonos
     * @covers ::actualizarTelefonos
     * @covers ::eliminarTelefonos
     */
    public function testGuardarTelefonosParaDomiciliosAsignadosAClientes() {
        $domicilio = $this->setUpTelefonosDomicilio();
        $telefonos = $domicilio->telefonos->toArray();
        $telefonos[0]['action'] = 1;
        $telefonos[0]['tipo'] = 'PRUEBA';
        $telefonos[1]['action'] = 2;

        $nuevo = factory(App\Telefono::class)->make()->toArray();
        $nuevo['action'] = 0;
        array_push($telefonos, $nuevo);

        $this->assertTrue($domicilio->guardarTelefonos($telefonos));
        $this->assertSame('PRUEBA', App\Telefono::find($telefonos[0]['id'])->tipo);
        $this->assertEmpty(App\Telefono::find($telefonos[1]['id']));
        $this->assertNotEmpty(App\Telefono::where('numero', $nuevo['numero'])->first());
    }

    /**
     * @coversNothing
     */
    private function setUpTelefonosDomicilio() {
        $domicilio = factory(App\Domicilio::class)->create();
        factory(App\Telefono::class, 5)->create([
            'domicilio_id' => $domicilio->id
        ]);
        $domicilio->load('telefonos');

        return $domicilio;
    }
}
