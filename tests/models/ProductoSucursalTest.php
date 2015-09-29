<?php

/**
* @coversDefaultClass \App\ProductoSucursal
*/
class ProductoSucursalTest extends TestCase
{

    protected $productoSucursal;

    /**
     * @coversNothing
     */
    public function testModeloEsValido()
    {
        $ps = factory(App\ProductoSucursal::class)->make();
        $this->assertTrue($ps->isValid());
    }

    /**
     * @coversNothing
     */
    public function testProveedorIdSeAsignaAutomaticamente()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal($sucursal);
        $ps = $producto->productosSucursales->last();
        $this->assertSame($sucursal->proveedor->id, $ps->proveedor_id);
    }

    /**
     * @coversNothing
     */
    public function testSucursalIdSeAsignaAutomaticamente()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addProveedor($sucursal->proveedor);
        $ps = $producto->productosSucursales->last();
        $this->assertSame($sucursal->id, $ps->sucursal_id);
    }

    /**
     * @covers ::existencias
     * @group relaciones
     */
    public function testExistencias()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal($sucursal);
        $ps = $producto->productosSucursales[0];
        $existencia = factory(App\Existencia::class)->make();
        $existencia->productoSucursal()->associate($ps)->save();
        $existencias = $ps->existencias;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class,
            $existencias);
        $this->assertInstanceOf(App\Existencia::class, $existencias[0]);
    }

    /**
     * @covers ::sucursal
     * @group relaciones
     */
    public function testSucursal()
    {
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal( factory(App\Sucursal::class)->create() );
        $ps = $producto->productosSucursales->last();
        $sucursal = $ps->sucursal;
        $this->assertInstanceOf(App\Sucursal::class, $sucursal);
    }

    /**
     * @covers ::precios
     * @group relaciones
     */
    public function testPrecios()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal($sucursal);
        $precio = factory(App\Precio::class)->make();
        $precio->productoSucursal()->associate($producto->productosSucursales[0])->save();
        $precios = $producto->productosSucursales[0]->precios;
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Collection::class, $precios);
        $this->assertInstanceOf(App\Precio::class, $precios[0]);
    }

    /**
     * @covers ::producto
     * @group relaciones
     */
    public function testProducto()
    {
        $sucursal = factory(App\Sucursal::class)->create();
        $producto = factory(App\Producto::class)->create();
        $producto->addSucursal($sucursal);
        $ps = $producto->productosSucursales[0];
        $testProducto = $ps->producto;
        $this->assertInstanceOf(App\Producto::class, $testProducto);
    }
}
