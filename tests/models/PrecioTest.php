<?php

/**
 * @coversDefaultClass \App\Precio
 */
class PrecioTest extends TestCase {

    protected $precio;

    /**
     * @coversNothing
     */
    public function testModeloEsValido() {
        $precio = factory(App\Precio::class)->make();
        $this->assertTrue($precio->isValid());
    }

    /**
     * @coversNothing
     * @group modelo_actualizable
     */
    public function testModeloEsActualizable() {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $precio->costo = 1991.0;
        $this->assertTrue($precio->isValid('update'));
        $this->assertTrue($precio->save());
        $this->assertSame(1991.0, $precio->costo);
    }

    /**
     * @coversNothing
     */
    public function testCostoEsRequerido() {
        $precio = factory(App\Precio::class, 'nullcosto')->make();
        $this->assertFalse($precio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCostoNoPuedeSerCeroOMenos() {
        $precio = factory(App\Precio::class, 'negcosto')->make();
        $this->assertFalse($precio->isValid());
        $precio->costo = 0;
        $this->assertFalse($precio->isValid());
        $precio->costo = 0.1;
        $this->assertTrue($precio->isValid());

    }

    /**
     * @coversNothing
     */
    public function testDescuentoEsOpcional() {
        $precio = factory(App\Precio::class, 'sindescuento')->make();
        $this->assertTrue($precio->save());
        $precio->descuento = 0.1;
        $this->assertTrue($precio->save());
    }

    /**
     * @coversNothing
     */
    public function testDescuentoEsPositivo() {
        $model = factory(App\Precio::class)->make([
            'descuento' => -0.15
        ]);
        $this->assertFalse($model->isValid());
        $model->descuento = 0.50;
        $this->assertTrue($model->isValid());
    }

    /**
     * @coversNothing
     */
    public function testDescuentoEsPorcentaje() {
        $precio = factory(App\Precio::class, 'sindescuento')->make();
        $precio->descuento = 'DESCUENTAZAZO';
        $this->assertFalse($precio->save());
        $precio->descuento = - 1;
        $this->assertFalse($precio->save());
        $precio->descuento = 1.5;
        $this->assertFalse($precio->save());
        $precio->descuento = 0.5;
        $this->assertTrue($precio->save());
    }


    /**
     * @coversNothing
     */
    public function testDescuentoPorDefaultEsCero() {
        $precio = factory(App\Precio::class, 'sindescuento')->make();
        $this->assertTrue($precio->save());
        $precio = $precio->fresh();
        $this->assertSame(0.00, floatval($precio->descuento));
    }

    /**
     * @coversNothing
     */
    public function testPreciosSonRequeridos() {
        $precio = factory(App\Precio::class, 'nullprecios')->make();
        $this->assertFalse($precio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testPreciosNoPuedenSerCeroOMenos() {
        $precio = factory(App\Precio::class, 'precioszero')->make();
        $this->assertFalse($precio->isValid());
        for ($i = 1; $i <= 10; $i ++) {
            $var = 'precio_' . $i;
            $precio->$var = 0.1;
        }
        $this->assertTrue($precio->isValid());
    }

    /**
     * @coversNothing
     */
    public function testCadaPrecioDebeSerMenorOIgualQueElAnterior() {
        $model = factory(App\Precio::class, 'precioszero')->make();

        for ($i = 1; $i <= 9; $i ++) {
            $var1 = 'precio_' . $i;
            $var2 = 'precio_' . ($i + 1);

            $model->$var1 = 12 - $i;

            $model->$var2 = $model->$var1 + 1;
            $this->assertFalse($model->isValid());

            $model->$var2 = $model->$var1 - 1;
            $this->assertTrue($model->isValid());
        }
    }

    /**
     * @coversNothing
     */
    public function testRevisadoEsOpcional() {
        $producto_sucursal = factory(App\ProductoSucursal::class)->create();
        $precio = factory(App\Precio::class, 'revisadonull')->make([
            'producto_sucursal_id' => $producto_sucursal->id
        ]);

        $this->assertNull($precio->revisado);
        $this->assertTrue($precio->save());
    }

    /**
     * @coversNothing
     */
    public function testRevisadoEsBooleano() {
        $producto_sucursal = factory(App\ProductoSucursal::class)->create();
        $precio = factory(App\Precio::class, 'revisadonull')->make([
            'revisado'             => 'Este precio está revisado',
            'producto_sucursal_id' => $producto_sucursal->id
        ]);

        $this->assertFalse($precio->isValid());
        $precio->revisado = true;
        $this->assertTrue($precio->save());

    }

    /**
     * @coversNothing
     */
    public function testRevisadoPorDefaultEsFalso() {
        $producto_sucursal = factory(App\ProductoSucursal::class)->create();
        $precio = factory(App\Precio::class, 'revisadonull')->make([
            'producto_sucursal_id' => $producto_sucursal->id
        ]);

        $this->assertTrue($precio->save());
        $precio = $precio->fresh();
        $this->assertNotNull($precio->revisado);
        $this->assertFalse(boolval($precio->revisado));
    }

    /**
     * @covers ::productoSucursal
     * @group relaciones
     */
    public function testProductoSucursal() {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $ps = $precio->productoSucursal;
        $this->assertInstanceOf(App\ProductoSucursal::class, $ps);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto() {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $testProducto = $precio->producto;
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }

    /**
     * @covers ::proveedor
     * @group relaciones
     */
    public function testProveedor() {
        $producto = factory(App\Producto::class)->create();
        $sucursal = factory(App\Sucursal::class)->create();
        $producto->addSucursal($sucursal);
        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $testProveedor = $precio->proveedor;
        $this->assertInstanceOf(App\Proveedor::class, $testProveedor);
    }
}
