<?php


class SucursalTest extends TestCase {

    /**
     * @coversNothing
     */
    public function testClaveDebeSerDe8CaracteresAlfa()
    {
        $sucursal = factory(App\Sucursal::class)->make();
        $this->assertTrue($sucursal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testClaveDebeSerUnica()
    {
        $sucursal1 = factory(App\Sucursal::class)->create();
        $sucursal2 = factory(App\Sucursal::class)->make([
            'clave' => $sucursal1->clave
        ]);
        $this->assertFalse($sucursal2->isValid());
    }

    /**
     * @coversNothing
     */
    public function testNombreDebeExistir()
    {
        $sucursal = factory(App\Sucursal::class)->make([
            'nombre' => ''
        ]);
        $this->assertFalse($sucursal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testHorariosDebeExistir()
    {
        $sucursal = factory(App\Sucursal::class)->make([
            'horarios' => ''
        ]);
        $this->assertFalse($sucursal->isValid());
    }

    /**
     * @coversNothing
     */
    public function testSucursalValida()
    {
        $sucursal = $sucursal = factory(App\Sucursal::class)->make();
        $this->assertTrue($sucursal->isValid());
    }

    /**
     * @covers ::proveedor
     */
    public function testProveedor()
    {
        $proveedor = factory(App\Proveedor::class)->create();
        $sucursal = factory(App\Sucursal::class)->make([
            'proveedor_id' => $proveedor->id
        ]);
        $this->assertEquals($proveedor, $sucursal->proveedor);
    }

    /**
     * @covers ::domicilio
     */
    public function testDomicilio()
    {
        $domicilio = factory(App\Domicilio::class)->create();
        $sucursal = factory(App\Sucursal::class)->create([
            'domicilio_id' => $domicilio->id
        ]);
        $this->assertEquals($domicilio, $sucursal->domicilio);
    }

    /**
     * @covers ::productos
     */
    public function testProductos()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal($sucursal);
        $testProductos = $sucursal->productos;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $testProductos);
        $this->assertInstanceOf(App\Producto::class, $testProductos[0]);
    }
}
