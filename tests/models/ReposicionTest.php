<?php

/**
 * @coversDefaultClass \App\Reposicion
 */
class ReposicionTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testTieneTimetamps() {
        $model = factory(App\Reposicion::class)->create();
        if ($model->touch()) {
            $this->assertNotEmpty($model->created_at);
            $this->assertNotEmpty($model->updated_at);
        }
        $this->assertTrue($model->timestamps);
    }

    /**
     * @coversNothing
     */
    public function testSerieEsRequerido() {
        $model = factory(App\Reposicion::class)->make([
            'serie' => ''
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSerieEsMaximo45Caracteres() {
        $model = factory(App\Reposicion::class, 'serielargo')->make();
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testProductoEsRequerido() {
        $model = factory(App\Reposicion::class)->make([
            'producto_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testGarantiaEsRequerido() {
        $model = factory(App\Reposicion::class)->make([
            'garantia_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testProveedorEsRequerido() {
        $model = factory(App\Reposicion::class)->make([
            'proveedor_id' => null
        ]);
        $this->assertFalse($model->isValid());
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto() {
        $parent = factory(App\Producto::class)->create();
        $child = factory(App\Reposicion::class)->create([
            'producto_id' => $parent->id
        ]);
        $parent_result = $child->producto;
        $this->assertInstanceOf('App\Producto', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::garantia
     * @group relaciones
     */
    public function testGarantia() {
        $parent = factory(App\Garantia::class)->create();
        $child = factory(App\Reposicion::class)->create([
            'garantia_id' => $parent->id
        ]);
        $parent_result = $child->garantia;
        $this->assertInstanceOf('App\Garantia', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }

    /**
     * @covers ::proveedor
     * @group relaciones
     */
    public function testProveedor() {
        $parent = factory(App\Proveedor::class)->create();
        $child = factory(App\Reposicion::class)->create([
            'proveedor_id' => $parent->id
        ]);
        $parent_result = $child->proveedor;
        $this->assertInstanceOf('App\Proveedor', $parent_result);
        $this->assertSame($parent->id, $parent_result->id);
    }



}
