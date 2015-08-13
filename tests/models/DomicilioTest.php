<?php

use App\Domicilio;

/**
 * @coversDefaultClass \App\Domicilio
 */
class DomicilioTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testDomicilioEsValido()
    {
        $domicilio = factory(Domicilio::class)->make();
        $this->assertTrue($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCalleEsRequerida()
    {
        $domicilio = factory(Domicilio::class)->make([
            'calle' => ''
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testLocalidadEsRequerida()
    {
        $domicilio = factory(Domicilio::class)->make([
            'localidad' => ''
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCodigoPostalAsociadoEsRequerido()
    {
        $domicilio = factory(Domicilio::class)->make([
            'codigo_postal_id' => null
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testTelefonoAsociadoEsRequerido()
    {
        $domicilio = factory(Domicilio::class)->make([
            'telefono_id' => null
        ]);
        $this->assertFalse($domicilio->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable()
    {
        $model = factory(App\Domicilio::class)->create();
        $model->calle = "Boulevard of Broken Dreams";
        $this->assertTrue($model->isValid('update'));
        $this->assertTrue($model->save());
    }

    /**
     * @covers ::codigoPostal
     * @group relaciones
     */
    public function testCodigoPostal()
    {
        $codigo_postal = factory(App\CodigoPostal::class)->create();
        $domicilio = factory(App\Domicilio::class)->create([
            'codigo_postal_id' => $codigo_postal->id
        ]);
        $codigo_postal_resultado = $domicilio->codigoPostal;
        $this->assertEquals($codigo_postal, $codigo_postal_resultado);
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
    public function testSucursales()
    {
        $domicilio = factory(App\Domicilio::class)->create();
        $sucursales = factory(App\Sucursal::class, 5)->create([
            'domicilio_id' => $domicilio->id
        ]);
        $sucursales_resultado = $domicilio->sucursales;
        for ($i = 0; $i < 5; $i ++)
        {
            $this->assertEquals($sucursales_resultado[$i], $sucursales[$i]);
        }
    }

    /**
     * @covers ::clientes
     * @group relaciones
     */
    public function testClientes()
    {
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
    public function testRazonesSocialesEmisores()
    {
        $domicilio = factory(App\Domicilio::class)->create();
        $rse = factory(App\RazonSocialEmisor::class, 'full')->create([
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
    public function testRazonesSocialesReceptores()
    {
        $domicilio = factory(App\Domicilio::class)->create();
        $rsr = factory(App\RazonSocialReceptor::class, 'full')->create([
            'domicilio_id' => $domicilio->id]);
        $rsrs = $domicilio->razonesSocialesReceptores;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $rsrs);
        $this->assertInstanceOf(App\RazonSocialReceptor::class, $rsrs[0]);
        $this->assertCount(1, $rsrs);
    }
}
