<?php

/**
 * @coversDefaultClass \App\Marca
 */
class MarcaTest extends TestCase {

    protected $marca;

    /**
     * @coversNothing
     */
    public function testModeloEsValido() {
        $marca = factory(App\Marca::class)->make();
        $this->assertTrue($marca->isValid());
        $this->assertTrue($marca->save());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $marca = factory(App\Marca::class)->create();
        $marca->nombre = 'MC Hammer';
        $this->assertTrue($marca->isValid('update'));
        $this->assertTrue($marca->save());
        $this->assertSame('MC Hammer', $marca->nombre);
    }

    /**
     * @coversNothing
     */
    public function testClaveNoPuedeSerDuplicada() {
        $marca = factory(App\Marca::class)->create();
        $dup = clone $marca;
        $this->assertFalse($dup->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveVaciaNoEsValido() {
        $marca = factory(App\Marca::class)->make(['clave' => '']);
        $this->assertFalse($marca->isValid());
        $this->assertFalse($marca->save());
    }

    /**
     * @coversNothing
     */
    public function testNombreVacioNoEsValido() {
        $marca = factory(App\Marca::class)->make(['nombre' => '']);
        $this->assertFalse($marca->isValid());
        $this->assertFalse($marca->save());
    }

    /**
     * @coversNothing
     */
    public function testClaveNoPuedeTenerMasDeTresDigitos() {
        $marca = factory(App\Marca::class)->make(['clave' => 'AAAA']);
        $this->assertFalse($marca->isValid());
        $this->assertFalse($marca->save());
    }

    /**
     * @coversNothing
     */
    public function testNombreNoPuedeTenerMasDe25Digitos() {
        $marca = factory(App\Marca::class, 'longname')->make();
        $this->assertFalse($marca->isValid());
        $this->assertFalse($marca->save());
    }

    /**
     * @coversNothing
     */
    public function testClaveDebeSerGuardadaEnMayusculas() {
        $marca = factory(App\Marca::class, 'lowercase')->make();
        $clave = strtoupper($marca->clave);
        $marca->save();
        $this->assertSame($clave, $marca->clave);
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatSupplierIdDebeSerEntero() {
        $marca = factory(App\Marca::class)->make([
            'icecat_supplier_id' => 'hello_parking_meter'
        ]);
        $this->assertFalse($marca->isValid());
        $marca->icecat_supplier_id = 1;
        $this->assertTrue($marca->isValid());
    }

    /**
     * @coversNothing
     * @group icecat
     */
    public function testIcecatSupplierIdEsOpcional() {
        $marca = factory(App\Marca::class)->make([
            'icecat_supplier_id' => 1
        ]);
        unset($marca->icecat_supplier_id);
        $this->assertTrue($marca->isValid());
    }

    /**
     * @covers ::productos
     * @group relaciones
     */
    public function testProductos() {
        $marca = factory(App\Marca::class)->create();
        $producto = factory(App\Producto::class)->create(['marca_id' => $marca->id]);
        $testProducto = $marca->productos[0];
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
